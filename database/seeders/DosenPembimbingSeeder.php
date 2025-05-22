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
                'id_dospem' => 1,
                'id_user' => 3, 
                'nip' => '198804162011031001',
                'created_at' => now(),
            ],
        ];

        DB::table('m_dospem')->insert($data);
    }
}
