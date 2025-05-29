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
                'id_user' => 81, 
                'nip' => '198804162011031001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 2,
                'id_user' => 82, 
                'nip' => '197506232005011002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 3,
                'id_user' => 83, 
                'nip' => '196809152000032001',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 4,
                'id_user' => 84, 
                'nip' => '197203102003121003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 5,
                'id_user' => 85, 
                'nip' => '198012182006042002',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 6,
                'id_user' => 86, 
                'nip' => '197605082002121004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 7,
                'id_user' => 87, 
                'nip' => '198302142007012003',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 8,
                'id_user' => 88, 
                'nip' => '196509271995031005',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 9,
                'id_user' => 89, 
                'nip' => '198107092008012004',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 10,
                'id_user' => 90, 
                'nip' => '197108232001121006',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 11,
                'id_user' => 91, 
                'nip' => '198504122010042005',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 12,
                'id_user' => 92, 
                'nip' => '197309112004121007',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 13,
                'id_user' => 93, 
                'nip' => '196902152000032006',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 14,
                'id_user' => 94, 
                'nip' => '198212252009121008',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 15,
                'id_user' => 95, 
                'nip' => '197711172003122007',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 16,
                'id_user' => 96, 
                'nip' => '196803211994031009',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 17,
                'id_user' => 97, 
                'nip' => '198601082011012008',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 18,
                'id_user' => 98, 
                'nip' => '197904232005011010',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 19,
                'id_user' => 99, 
                'nip' => '197010102000032009',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_dospem' => 20,
                'id_user' => 100, 
                'nip' => '198508182012121011',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_dospem')->insert($data);
    }
}