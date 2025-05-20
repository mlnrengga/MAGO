<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_admin' => 1,
                'id_user' => 1, 
                'nip' => '12345678901234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_admin')->insert($data);
    }
}
