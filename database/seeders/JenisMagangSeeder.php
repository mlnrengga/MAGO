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
            ['nama_jenis_magang' => 'Magang Industri'],
            ['nama_jenis_magang' => 'Magang Kampus Merdeka'],
            ['nama_jenis_magang' => 'Magang Penelitian'],
            ['nama_jenis_magang' => 'Magang Startup'],
            ['nama_jenis_magang' => 'PKL Mandiri'],
            ['nama_jenis_magang' => 'Magang Pemerintahan'],
            ['nama_jenis_magang' => 'Magang Sosial Teknologi'],
            ['nama_jenis_magang' => 'Magang Remote'],
            ['nama_jenis_magang' => 'Magang Freelance'],
            ['nama_jenis_magang' => 'Magang Teaching Assistant'],
        ];

        DB::table('m_jenis_magang')->insert($data);
    }
}
