<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_perusahaan' => 1,
                'id_admin' => 1,
                'nama' => 'PT. Maju Mundur',
                'alamat' => 'Jl. Raya No. 1',
                'no_telepon' => '08123456789',
                'email' => 'qNw0s@example.com',
                'website' => 'www.maju-mundur.com',
                'created_at' => now(),
            ],
        ];
        DB::table('m_perusahaan')->insert($data);
    }
}
