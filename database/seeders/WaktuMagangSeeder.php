<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WaktuMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('m_waktu_magang')->delete();
        DB::statement('ALTER TABLE m_waktu_magang AUTO_INCREMENT = 1');

        $data = [];
        for ($i = 1; $i <= 6; $i++) {
            $data[] = [
                'id_waktu_magang' => $i,
                'waktu_magang' => $i . ' Bulan',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('m_waktu_magang')->insert($data);
        $this->command->info('Berhasil menyeeder ' . count($data) . ' data waktu magang');
    }
}