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
                'nama' => 'Admin',
                'password' => bcrypt('admin123'),
                'alamat' => 'Jl. Admin No. 1',
                'no_telepon' => '081234567890',
                'role' => 'admin',
            ],
            [
                'nama' => 'Mahasiswa',
                'password' => bcrypt('mahasiswa123'),
                'alamat' => 'Jl. Mahasiswa No. 2',
                'no_telepon' => '081234567891',
                'role' => 'mahasiswa',
            ],
            [
                'nama' => 'Dosen Pembimbing',
                'password' => bcrypt('dosen123'),
                'alamat' => 'Jl. Dosen No. 3',
                'no_telepon' => '081234567892',
                'role' => 'dosen_pembimbing',
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}
