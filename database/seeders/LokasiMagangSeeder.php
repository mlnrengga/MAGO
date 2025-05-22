<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LokasiMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_lokasi_magang' => 1, 'nama_lokasi' => 'Jakarta'],
            ['id_lokasi_magang' => 2, 'nama_lokasi' => 'Surabaya'],
            ['id_lokasi_magang' => 3, 'nama_lokasi' => 'Malang'],
            ['id_lokasi_magang' => 4, 'nama_lokasi' => 'Bandung'],
        ];

        DB::table('m_lokasi_magang')->insert($data);
    }
}
