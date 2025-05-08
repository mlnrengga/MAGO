<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_jenis_magang' => 1, 'nama_jenis_magang' => 'Magang Industri'],
            ['id_jenis_magang' => 2, 'nama_jenis_magang' => 'Magang Kampus Merdeka'],
            ['id_jenis_magang' => 3, 'nama_jenis_magang' => 'Magang Penelitian'],
            ['id_jenis_magang' => 4, 'nama_jenis_magang' => 'Magang Startup'],
            ['id_jenis_magang' => 5, 'nama_jenis_magang' => 'PKL Mandiri'],
            ['id_jenis_magang' => 6, 'nama_jenis_magang' => 'Magang Pemerintahan'],
            ['id_jenis_magang' => 7, 'nama_jenis_magang' => 'Magang Sosial Teknologi'],
            ['id_jenis_magang' => 8, 'nama_jenis_magang' => 'Magang Remote'],
            ['id_jenis_magang' => 9, 'nama_jenis_magang' => 'Magang Freelance'],
            ['id_jenis_magang' => 10, 'nama_jenis_magang' => 'Magang Teaching Assistant'],
        ];

        DB::table('m_jenis_magang')->insert($data);
    }
}
