<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 3, 
                'nip' => '198804162011031001',
                'id_lokasi_magang' => 1, 
                'id_jenis_magang' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_dosen_pembimbing')->insert($data);
    }
}
