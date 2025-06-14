<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BimbinganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data yang ada
        DB::table('r_bimbingan')->delete();

        // Ambil semua penempatan magang (baik yang berlangsung maupun selesai)
        $penempatanMagang = DB::table('t_penempatan_magang')
            ->get();

        $this->command->info("Memproses {$penempatanMagang->count()} data penempatan magang");

        $bimbinganData = [];
        $penempatanDenganDosen = 0;

        foreach ($penempatanMagang as $penempatan) {
            // Dapatkan pengajuan magang terkait
            $pengajuan = DB::table('t_pengajuan_magang')
                ->where('id_pengajuan', $penempatan->id_pengajuan)
                ->first();

            if (!$pengajuan) {
                $this->command->warn("Pengajuan tidak ditemukan untuk id_pengajuan: {$penempatan->id_pengajuan}");
                continue;
            }

            // Dapatkan lowongan magang terkait
            $lowongan = DB::table('t_lowongan_magang')
                ->where('id_lowongan', $pengajuan->id_lowongan)
                ->first();

            if (!$lowongan) {
                $this->command->warn("Lowongan tidak ditemukan untuk id_lowongan: {$pengajuan->id_lowongan}");
                continue;
            }

            // Dapatkan bidang keahlian dari lowongan
            $bidangLowongan = DB::table('r_lowongan_bidang')
                ->where('id_lowongan', $lowongan->id_lowongan)
                ->pluck('id_bidang')
                ->toArray();

            if (empty($bidangLowongan)) {
                $this->command->warn("Lowongan tidak memiliki bidang keahlian: {$lowongan->id_lowongan}");
                continue;
            }

            // Cari dosen pembimbing yang memiliki bidang keahlian yang cocok
            $dosenPembimbing = DB::table('m_dospem')
                ->join('r_dospem_bidang_keahlian', 'm_dospem.id_dospem', '=', 'r_dospem_bidang_keahlian.id_dospem')
                ->whereIn('r_dospem_bidang_keahlian.id_bidang', $bidangLowongan)
                ->select('m_dospem.id_dospem', DB::raw('count(r_dospem_bidang_keahlian.id_bidang) as matching_skills'))
                ->groupBy('m_dospem.id_dospem')
                ->orderByDesc('matching_skills')
                ->get();

            // Jika tidak ada dosen yang cocok dengan bidang, ambil dosen secara acak
            if ($dosenPembimbing->isEmpty()) {
                $dosenPembimbing = DB::table('m_dospem')
                    ->inRandomOrder()
                    ->limit(1)
                    ->get();
                
                if ($dosenPembimbing->isEmpty()) {
                    $this->command->warn("Tidak ada dosen pembimbing tersedia");
                    continue;
                }
            }

            // Pilih dosen yang paling cocok (dengan matching bidang terbanyak)
            $selectedDospem = $dosenPembimbing->first();
            
            // Cek apakah dosen ini sudah punya banyak bimbingan
            $countBimbingan = DB::table('r_bimbingan')
                ->where('id_dospem', $selectedDospem->id_dospem)
                ->count();
            
            // Jika dosen sudah membimbing lebih dari 5 mahasiswa, cari dosen lain
            if ($countBimbingan > 5 && $dosenPembimbing->count() > 1) {
                $selectedDospem = $dosenPembimbing->skip(1)->first();
            }

            // Tambahkan data bimbingan
            $bimbinganData[] = [
                'id_dospem' => $selectedDospem->id_dospem,
                'id_penempatan' => $penempatan->id_penempatan,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $penempatanDenganDosen++;
        }

        // Masukkan data bimbingan ke database
        if (!empty($bimbinganData)) {
            DB::table('r_bimbingan')->insert($bimbinganData);
            $this->command->info("Berhasil menyeeder {$penempatanDenganDosen} data bimbingan dari {$penempatanMagang->count()} penempatan magang");
        } else {
            $this->command->info("Tidak ada data bimbingan yang dibuat");
        }
    }
}