<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_user' => 1,
                'nama' => 'Admin Satu',
                'password' => bcrypt('12345678'),
                'alamat' => 'Jl. Mawar Satu No. 1',
                'no_telepon' => '081234567890',
                'profile_picture' => 'zzz', 
                'id_role' => 1,
            ],
            [
                'id_user' => 2,
                'nama' => 'Cristiano Ronaldo',
                'password' => bcrypt('12345678'),
                'alamat' => 'Jl. Melati No. 2',
                'no_telepon' => '081234567891',
                'profile_picture' => 'zzz', 
                'id_role' => 2,
            ],
            [
                'id_user' => 3,
                'nama' => 'Budi Santoso, S.Kom, M.Kom',
                'password' => bcrypt('12345678'),
                'alamat' => 'Jl. Kenanga No. 3',
                'no_telepon' => '081234567892',
                'profile_picture' => 'zzz', 
                'id_role' => 3,
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}
