<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua id mahasiswa yang ada
        $mahasiswaIds = DB::table('m_mahasiswa')->pluck('id_mahasiswa')->toArray();
        
        // Asumsikan ada beberapa daerah magang (dari 1 hingga 514, sesuai dengan jumlah kabupaten/kota di Indonesia)
        // Jika ada data spesifik dari m_daerah_magang, sebaiknya gunakan itu
        $maxDaerah = 514;
        
        // Asumsikan ada 2 jenis waktu magang: 3 Bulan (id: 1) dan 6 Bulan (id: 2)
        $waktuMagangIds = [1, 2];
        
        // Asumsikan ada 2 jenis insentif: Ada (id: 1) dan Tidak Ada (id: 2)
        $insentifIds = [1, 2];
        
        $data = [];
        $id = 1;
        
        foreach ($mahasiswaIds as $mahasiswaId) {
            // Pilih daerah magang secara acak
            $daerahMagang = rand(1, $maxDaerah);
            
            // Pilih waktu magang secara acak
            $waktuMagang = $waktuMagangIds[array_rand($waktuMagangIds)];
            
            // Pilih insentif secara acak - dengan preferensi lebih ke arah "Ada Insentif"
            // 70% kemungkinan memilih "Ada Insentif" (id: 1)
            $insentif = (rand(1, 100) <= 70) ? 1 : 2;
            
            // Tentukan ranking untuk setiap preferensi
            // Untuk daerah: 1-5 (prioritas tertinggi ke terendah)
            // Mahasiswa dari semester lebih tinggi cenderung lebih fleksibel dalam memilih daerah
            // (untuk membuat data lebih realistis)
            $semester = DB::table('m_mahasiswa')->where('id_mahasiswa', $mahasiswaId)->value('semester');
            $rankingDaerah = min(5, max(1, rand(1, 3) + floor($semester / 2)));
            
            // Untuk waktu magang: 1-3
            // Mahasiswa umumnya lebih suka waktu magang yang lebih pendek
            $rankingWaktuMagang = ($waktuMagang == 1) ? rand(1, 2) : rand(2, 3);
            
            // Untuk insentif: 1-3
            // Mahasiswa umumnya lebih memprioritaskan insentif
            $rankingInsentif = ($insentif == 1) ? 1 : rand(2, 3);
            
            $data[] = [
                'id_preferensi' => $id,
                'id_mahasiswa' => $mahasiswaId,
                'id_daerah_magang' => $daerahMagang,
                'ranking_daerah' => $rankingDaerah,
                'id_waktu_magang' => $waktuMagang,
                'ranking_waktu_magang' => $rankingWaktuMagang,
                'id_insentif' => $insentif,
                'ranking_insentif' => $rankingInsentif,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $id++;
        }
        
        DB::table('r_preferensi_mahasiswa')->insert($data);
    }
}