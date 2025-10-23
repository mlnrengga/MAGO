<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LogMagangSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan tabel
        DB::table('t_log_magang')->delete();
        DB::statement('ALTER TABLE t_log_magang AUTO_INCREMENT = 1');

        // Ambil data penempatan magang yang ada
        $penempatan = DB::table('t_penempatan_magang')->get();

        $data = [];
        foreach ($penempatan as $p) {
            // Set jumlah log acak antara 3–6 per penempatan
            $jumlahLog = rand(3, 6);

            for ($i = 0; $i < $jumlahLog; $i++) {
                $tanggal = Carbon::now()->subDays(rand(1, 30)); // tanggal acak 1–30 hari lalu
                $statusList = ['masuk', 'izin', 'sakit', 'cuti'];
                $status = $statusList[array_rand($statusList)];

                $data[] = [
                    'id_penempatan' => $p->id_penempatan,
                    'tanggal_log' => $tanggal->toDateString(),
                    'keterangan' => match ($status) {
                        'masuk' => 'Melaksanakan tugas harian di tempat magang',
                        'izin' => 'Izin karena ada urusan pribadi',
                        'sakit' => 'Tidak masuk karena sakit',
                        'cuti' => 'Cuti karena keperluan keluarga',
                        default => 'Aktivitas harian',
                    },
                    'status' => $status,
                    'file_bukti' => match ($status) {
                        'masuk' => 'laporan_harian_' . $p->id_penempatan . '.pdf',
                        'sakit' => 'surat_sakit_' . $p->id_penempatan . '.jpg',
                        'izin' => 'surat_izin_' . $p->id_penempatan . '.jpg',
                        'cuti' => 'surat_cuti_' . $p->id_penempatan . '.jpg',
                        default => null,
                    },
                    'feedback_progres' => $status === 'masuk'
                        ? 'Kinerja baik dan tepat waktu'
                        : null,
                    'created_at' => $tanggal,
                    'updated_at' => $tanggal,
                ];
            }
        }

        DB::table('t_log_magang')->insert($data);

        $this->command->info('Berhasil men-seeder ' . count($data) . ' data log magang');
    }
}
