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
            ['nama_bidang_keahlian' => 'Web Development'],
            ['nama_bidang_keahlian' => 'Mobile Development'],
            ['nama_bidang_keahlian' => 'UI/UX Design'],
            ['nama_bidang_keahlian' => 'Network Engineering'],
            ['nama_bidang_keahlian' => 'Cloud Computing'],
            ['nama_bidang_keahlian' => 'Cyber Security'],
            ['nama_bidang_keahlian' => 'Database Administration'],
            ['nama_bidang_keahlian' => 'Game Development'],
            ['nama_bidang_keahlian' => 'Embedded Systems'],
            ['nama_bidang_keahlian' => 'Machine Learning'],
            ['nama_bidang_keahlian' => 'Artificial Intelligence'],
            ['nama_bidang_keahlian' => 'Data Analysis'],
            ['nama_bidang_keahlian' => 'DevOps'],
            ['nama_bidang_keahlian' => 'Software Testing'],
            ['nama_bidang_keahlian' => 'Business Intelligence'],
            ['nama_bidang_keahlian' => 'IT Support'],
            ['nama_bidang_keahlian' => 'Blockchain Development'],
            ['nama_bidang_keahlian' => 'Digital Forensics'],
            ['nama_bidang_keahlian' => 'AR/VR Development'],
            ['nama_bidang_keahlian' => 'Robotic Process Automation'],
        ];

        DB::table('m_bidang_keahlian')->insert($data);
    }
}
