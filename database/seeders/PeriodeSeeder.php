<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_periode' => 1,
                'nama_periode' => '2024/2025 Genap',
                'created_at' => now(),
            ],
        ];

        DB::table('m_periode')->insert($data);
    }
}
