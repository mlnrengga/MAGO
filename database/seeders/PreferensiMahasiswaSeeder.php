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
        $data = [
            [
                'id_mahasiswa' => 1, 
                'id_bidang_keahlian' => 1, 
                'ranking_bidang' => 1,

                'id_lokasi_magang' => 1, 
                'ranking_lokasi' => 2,

                'id_jenis_magang' => 1, 
                'ranking_jenis' => 3,

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('r_preferensi_mahasiswa')->insert($data);
    }
}
