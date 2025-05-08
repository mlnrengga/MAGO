<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_mahasiswa' => 1,
                'id_user' => 2, 
                'nim' => '215150700111011',
                'program_studi' => 'Teknik Informatika',
                'status_pengajuan_magang' => 'belum',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_mahasiswa')->insert($data);

    }
}
