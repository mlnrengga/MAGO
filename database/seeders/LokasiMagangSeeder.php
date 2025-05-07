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
            ['kota_lokasi_magang' => 'Jakarta'],
            ['kota_lokasi_magang' => 'Surabaya'],
            ['kota_lokasi_magang' => 'Malang'],
            ['kota_lokasi_magang' => 'Bandung'],
        ];

        DB::table('m_lokasi_magang')->insert($data);
    }
}
