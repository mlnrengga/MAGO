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
            ['id_lokasi_magang' => 1, 'kota_lokasi_magang' => 'Jakarta'],
            ['id_lokasi_magang' => 2, 'kota_lokasi_magang' => 'Surabaya'],
            ['id_lokasi_magang' => 3, 'kota_lokasi_magang' => 'Malang'],
            ['id_lokasi_magang' => 4, 'kota_lokasi_magang' => 'Bandung'],
        ];

        DB::table('m_lokasi_magang')->insert($data);
    }
}
