<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BidangKeahlianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id_bidang_keahlian' => 1, 'nama_bidang_keahlian' => 'Web Development'],
            ['id_bidang_keahlian' => 2, 'nama_bidang_keahlian' => 'Mobile Development'],
            ['id_bidang_keahlian' => 3, 'nama_bidang_keahlian' => 'UI/UX Design'],
            ['id_bidang_keahlian' => 4, 'nama_bidang_keahlian' => 'Network Engineering'],
            ['id_bidang_keahlian' => 5, 'nama_bidang_keahlian' => 'Cloud Computing'],
            ['id_bidang_keahlian' => 6, 'nama_bidang_keahlian' => 'Cyber Security'],
            ['id_bidang_keahlian' => 7, 'nama_bidang_keahlian' => 'Database Administration'],
            ['id_bidang_keahlian' => 8, 'nama_bidang_keahlian' => 'Game Development'],
            ['id_bidang_keahlian' => 9, 'nama_bidang_keahlian' => 'Embedded Systems'],
            ['id_bidang_keahlian' => 10, 'nama_bidang_keahlian' => 'Machine Learning'],
            ['id_bidang_keahlian' => 11, 'nama_bidang_keahlian' => 'Artificial Intelligence'],
            ['id_bidang_keahlian' => 12, 'nama_bidang_keahlian' => 'Data Analysis'],
            ['id_bidang_keahlian' => 13, 'nama_bidang_keahlian' => 'DevOps'],
            ['id_bidang_keahlian' => 14, 'nama_bidang_keahlian' => 'Software Testing'],
            ['id_bidang_keahlian' => 15, 'nama_bidang_keahlian' => 'Business Intelligence'],
            ['id_bidang_keahlian' => 16, 'nama_bidang_keahlian' => 'IT Support'],
            ['id_bidang_keahlian' => 17, 'nama_bidang_keahlian' => 'Blockchain Development'],
            ['id_bidang_keahlian' => 18, 'nama_bidang_keahlian' => 'Digital Forensics'],
            ['id_bidang_keahlian' => 19, 'nama_bidang_keahlian' => 'AR/VR Development'],
            ['id_bidang_keahlian' => 20, 'nama_bidang_keahlian' => 'Robotic Process Automation'],
        ];

        DB::table('m_bidang_keahlian')->insert($data);
    }
}
