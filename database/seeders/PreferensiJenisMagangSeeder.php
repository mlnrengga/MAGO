<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiJenisMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua data preferensi mahasiswa
        $preferensi = DB::table('r_preferensi_mahasiswa')->get();
        
        // Ambil semua jenis magang
        $jenisMagang = DB::table('m_jenis_magang')->get();
        $totalJenisMagang = $jenisMagang->count();
        
        // Pastikan ada jenis magang di database
        if ($totalJenisMagang == 0) {
            throw new \Exception('Tabel m_jenis_magang kosong. Harap isi terlebih dahulu.');
        }
        
        $data = [];
        $timestamp = now();
        
        foreach ($preferensi as $pref) {
            // Untuk tiap mahasiswa, tentukan berapa jenis magang yang akan diranking
            // Sebagian besar mahasiswa akan meranking semua jenis magang
            // Beberapa mahasiswa hanya akan meranking beberapa jenis magang saja
            $jenisMagangToRank = ($totalJenisMagang > 3 && rand(1, 10) <= 2) ? 
                rand(3, $totalJenisMagang - 1) : $totalJenisMagang;
            
            // Acak urutan jenis magang untuk diranking
            $jenisMagangIDs = $jenisMagang->pluck('id_jenis_magang')->toArray();
            shuffle($jenisMagangIDs);
            $selectedJenisMagang = array_slice($jenisMagangIDs, 0, $jenisMagangToRank);
            
            // Buat preferensi berdasarkan jurusan mahasiswa
            // Cari jurusan/prodi mahasiswa
            $mahasiswa = DB::table('m_mahasiswa')
                ->where('id_mahasiswa', $pref->id_mahasiswa)
                ->first();
            
            if (!$mahasiswa) {
                continue; // Skip jika tidak ditemukan
            }
            
            $idProdi = $mahasiswa->id_prodi;
            
            // Tentukan preferensi berdasarkan jurusan (misalnya dari data yang sudah ada)
            // Asumsi: id_prodi 1 adalah Teknik Informatika, 2 adalah Sistem Informasi Bisnis
            $preferencesByProdi = [];
            
            if ($totalJenisMagang >= 5) {
                // Asumsi: id_jenis_magang berikut
                // 1: Magang Kampus Merdeka
                // 2: Praktik Kerja Lapangan (PKL)
                // 3: Magang Mandiri
                // 4: Magang Kewirausahaan
                // 5: Magang Industri
                
                // Untuk Teknik Informatika
                $preferencesByProdi[1] = [
                    1 => [1, 2], // Peluang ranking 1-2 untuk Kampus Merdeka
                    2 => [2, 3], // Peluang ranking 2-3 untuk PKL
                    3 => [1, 3], // Peluang ranking 1-3 untuk Magang Mandiri
                    4 => [3, 5], // Peluang ranking 3-5 untuk Kewirausahaan
                    5 => [2, 4]  // Peluang ranking 2-4 untuk Magang Industri
                ];
                
                // Untuk Sistem Informasi Bisnis
                $preferencesByProdi[2] = [
                    1 => [2, 3], // Peluang ranking 2-3 untuk Kampus Merdeka
                    2 => [1, 2], // Peluang ranking 1-2 untuk PKL
                    3 => [2, 4], // Peluang ranking 2-4 untuk Magang Mandiri
                    4 => [1, 3], // Peluang ranking 1-3 untuk Kewirausahaan
                    5 => [3, 5]  // Peluang ranking 3-5 untuk Magang Industri
                ];
            } else {
                // Default untuk kasus dimana jumlah jenis magang berbeda
                $defaultRanges = [];
                for ($i = 1; $i <= $totalJenisMagang; $i++) {
                    $defaultRanges[$i] = [1, $totalJenisMagang];
                }
                $preferencesByProdi[1] = $preferencesByProdi[2] = $defaultRanges;
            }
            
            // Default preference bila prodi tidak diketahui
            $defaultPreferences = [];
            for ($i = 1; $i <= $totalJenisMagang; $i++) {
                $defaultPreferences[$i] = [1, $totalJenisMagang];
            }
            
            // Buat array untuk melacak ranking yang sudah digunakan
            $usedRankings = [];
            
            foreach ($selectedJenisMagang as $jenisMagangId) {
                // Ambil range ranking untuk jenis magang ini berdasarkan prodi
                $rankRange = $preferencesByProdi[$idProdi][$jenisMagangId] ?? 
                             $defaultPreferences[$jenisMagangId] ?? 
                             [1, $totalJenisMagang];
                
                // Coba temukan ranking yang belum digunakan dalam range
                $ranking = null;
                $potentialRankings = range($rankRange[0], $rankRange[1]);
                shuffle($potentialRankings);
                
                foreach ($potentialRankings as $potentialRank) {
                    if (!in_array($potentialRank, $usedRankings)) {
                        $ranking = $potentialRank;
                        $usedRankings[] = $potentialRank;
                        break;
                    }
                }
                
                // Jika tidak menemukan ranking yang kosong dalam range, gunakan ranking terdekat yang tersedia
                if ($ranking === null) {
                    for ($r = 1; $r <= $totalJenisMagang; $r++) {
                        if (!in_array($r, $usedRankings)) {
                            $ranking = $r;
                            $usedRankings[] = $r;
                            break;
                        }
                    }
                }
                
                // Jika masih null (seharusnya tidak terjadi), gunakan ranking default
                if ($ranking === null) {
                    $ranking = 1;
                }
                
                $data[] = [
                    'id_preferensi' => $pref->id_preferensi,
                    'id_jenis_magang' => $jenisMagangId,
                    'ranking_jenis_magang' => $ranking,
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp
                ];
            }
        }
        
        // Insert ke database
        DB::table('r_preferensi_jenis_magang')->insert($data);
    }
}