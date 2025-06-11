<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LowonganMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_lowongan_magang')->delete();
        DB::statement('ALTER TABLE t_lowongan_magang AUTO_INCREMENT = 1');

        $faker = \Faker\Factory::create('id_ID');
        $periodeList = DB::table('m_periode')
            ->whereIn('nama_periode', ['2024/2025 Ganjil', '2024/2025 Genap'])
            ->get();

        $waktuMagang = DB::table('m_waktu_magang')->pluck('id_waktu_magang')->toArray();
        $perusahaan = DB::table('m_perusahaan')->pluck('id_perusahaan')->toArray();
        $daerah = DB::table('m_daerah_magang')->pluck('id_daerah_magang')->toArray();
        $jenisMagang = DB::table('m_jenis_magang')->pluck('id_jenis_magang')->toArray();
        $insentif = DB::table('m_insentif')->pluck('id_insentif')->toArray();

        $data = [];
        $counter = 1;

        foreach ($periodeList as $p) {
            $tahun = intval(substr($p->nama_periode, 0, 4));
            $jenis = strpos($p->nama_periode, 'Ganjil') !== false ? 'Ganjil' : 'Genap';

            if ($jenis == 'Ganjil') {
                $start = Carbon::create($tahun, 7, 1);
            } else {
                $start = Carbon::create($tahun + 1, 1, 1);
            }

            for ($i = 0; $i < 10; $i++) { // 10 lowongan per periode
                $id_waktu_magang = $waktuMagang[array_rand($waktuMagang)];
                $tanggal_posting = $start->copy()->subMonths(rand(2, 4))->addDays(rand(0, 20));
                $batas_akhir = $start->copy()->subDays(rand(10, 35));

                $data[] = [
                    'id_lowongan' => $counter++,
                    'id_jenis_magang' => $jenisMagang[array_rand($jenisMagang)],
                    'id_perusahaan' => $perusahaan[array_rand($perusahaan)],
                    'id_daerah_magang' => $daerah[array_rand($daerah)],
                    'judul_lowongan' => 'Magang ' . ucfirst($faker->unique()->word()),
                    'deskripsi_lowongan' => $faker->paragraph(),
                    'tanggal_posting' => $tanggal_posting->format('Y-m-d'),
                    'batas_akhir_lamaran' => $batas_akhir->format('Y-m-d'),
                    'status' => 'Aktif',
                    'id_periode' => $p->id_periode,
                    'id_waktu_magang' => $id_waktu_magang,
                    'id_insentif' => $insentif[array_rand($insentif)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('t_lowongan_magang')->insert($data);
        $this->command->info('Berhasil menyeeder ' . count($data) . ' data lowongan magang');
    }
}