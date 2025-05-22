<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_role' => 1,
                'nama_role' => 'Admin',
                'kode_role' => 'ADM',
            ],
            [
                'id_role' => 2,
                'nama_role' => 'Mahasiswa',
                'kode_role' => 'MHS',
            ],
            [
                'id_role' => 3,
                'nama_role' => 'Dosen Pembimbing',
                'kode_role' => 'DSP',
            ],
        ];

        DB::table('m_role')->insert($data);
    }
}
