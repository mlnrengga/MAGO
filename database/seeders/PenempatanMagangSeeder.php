<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenempatanMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_penempatan_magang')->delete();
        DB::statement('ALTER TABLE t_penempatan_magang AUTO_INCREMENT = 1');

        $pengajuan = DB::table('t_pengajuan_magang')->where('status', 'Diterima')->get();
        $mahasiswa = DB::table('m_mahasiswa')->get()->keyBy('id_mahasiswa');

        $data = [];
        $counter = 1;
        foreach ($pengajuan as $p) {
            $mhs = $mahasiswa[$p->id_mahasiswa];
            $status = 'Berlangsung';
            if ($mhs->semester == 8) {
                $status = 'Selesai';
            }
            $createdAt = $p->tanggal_diterima ?: $p->created_at;

            $data[] = [
                'id_penempatan' => $counter++,
                'id_mahasiswa' => $p->id_mahasiswa,
                'id_pengajuan' => $p->id_pengajuan,
                'status' => $status,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        DB::table('t_penempatan_magang')->insert($data);
        $this->command->info('Berhasil menyeeder ' . count($data) . ' data penempatan magang');
    }
}