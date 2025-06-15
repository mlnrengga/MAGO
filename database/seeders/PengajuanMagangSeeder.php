<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengajuanMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('t_pengajuan_magang')->delete();
        DB::statement('ALTER TABLE t_pengajuan_magang AUTO_INCREMENT = 1');

        $mahasiswa = DB::table('m_mahasiswa')->get();
        $lowongan = DB::table('t_lowongan_magang')
            ->whereIn('id_periode', function($q) {
                $q->select('id_periode')->from('m_periode')
                ->whereIn('nama_periode', [
                    '2024/2025 Ganjil',
                    '2024/2025 Genap'
                ]);
            })->get();

        if ($lowongan->isEmpty()) {
            throw new \Exception("TIDAK ADA LOWONGAN pada periode 2024/2025 Ganjil/Genap. Cek LowonganMagangSeeder!");
        }
        if ($mahasiswa->isEmpty()) {
            throw new \Exception("TIDAK ADA MAHASISWA!");
        }

        $alasan_penolakan_profesional = [
            'Motivasi yang disampaikan pada surat pengantar belum menunjukkan minat yang kuat terhadap posisi magang ini.',
            'Hasil evaluasi menunjukkan kemampuan komunikasi perlu ditingkatkan untuk mendukung peran yang dituju.',
            'Proposal pengajuan magang yang diajukan kurang menggambarkan pemahaman terhadap bidang kerja di perusahaan.',
            'Belum ada pengalaman organisasi atau kegiatan yang relevan untuk mendukung pelaksanaan tugas magang.',
            'Terdapat kandidat lain yang lebih sesuai dengan kebutuhan dan profil posisi magang saat ini.',
            'Surat pengantar atau dokumen yang diberikan belum secara jelas menjabarkan tujuan dan harapan selama magang.',
            'Pengetahuan dasar terkait bidang magang dinilai masih kurang memadai.',
            'Kesiapan waktu pelaksanaan magang tidak sesuai dengan jadwal yang telah ditetapkan oleh perusahaan.',
            'Rekomendasi dari dosen pembimbing belum mendukung aspek softskill yang diperlukan.',
            'Kandidat diharapkan dapat memperbaiki dan meningkatkan keterampilan interpersonal sebelum mengajukan kembali.',
        ];

        $counter = 1;
        $data = [];
        $existing = [];
        // Window bulan: Jul 2024 - Jun 2025
        $start = Carbon::create(2024, 7, 1);
        $end = Carbon::create(2025, 6, 30);

        // Generate pengajuan untuk setiap bulan window
        for ($date = $start->copy(); $date <= $end; $date->addMonth()) {
            // 4 pengajuan per bulan
            for ($i=0; $i<4; $i++) {
                $m = $mahasiswa->random();
                $l = $lowongan->random();
                $key = $m->id_mahasiswa.'-'.$l->id_lowongan;
                if (isset($existing[$key])) continue;
                $existing[$key] = true;

                $tanggal_pengajuan = $date->copy()->addDays(rand(0, 27));
                $statusRand = rand(1, 100);
                if ($statusRand <= 60) $status = 'Diajukan';
                elseif ($statusRand <= 90) $status = 'Diterima';
                else $status = 'Ditolak';

                $tanggal_diterima = null;
                $alasan_penolakan = null;
                if ($status == 'Diterima') {
                    $tanggal_diterima = $tanggal_pengajuan->copy()->addDays(rand(1, 10));
                    if ($tanggal_diterima->month > $tanggal_pengajuan->month) {
                        $tanggal_diterima = $tanggal_pengajuan->copy()->endOfMonth();
                    }
                } elseif ($status == 'Ditolak') {
                    $alasan_penolakan = $alasan_penolakan_profesional[array_rand($alasan_penolakan_profesional)];
                }

                $data[] = [
                    'id_pengajuan' => $counter++,
                    'id_mahasiswa' => $m->id_mahasiswa,
                    'id_lowongan' => $l->id_lowongan,
                    'tanggal_pengajuan' => $tanggal_pengajuan->format('Y-m-d'),
                    'status' => $status,
                    'tanggal_diterima' => $tanggal_diterima ? $tanggal_diterima->format('Y-m-d') : null,
                    'alasan_penolakan' => $alasan_penolakan,
                    'created_at' => $tanggal_pengajuan->format('Y-m-d H:i:s'),
                    'updated_at' => $tanggal_diterima ? $tanggal_diterima->format('Y-m-d H:i:s') : $tanggal_pengajuan->format('Y-m-d H:i:s'),
                ];
            }
        }

        // Tambahkan data random lain jika ingin jumlah lebih banyak (opsional)
        while (count($data) < 150) {
            $m = $mahasiswa->random();
            $l = $lowongan->random();
            $key = $m->id_mahasiswa.'-'.$l->id_lowongan;
            if (isset($existing[$key])) continue;
            $existing[$key] = true;
            $tanggal_pengajuan = $start->copy()->addDays(rand(0, $end->diffInDays($start)));
            $statusRand = rand(1, 100);
            if ($statusRand <= 60) $status = 'Diajukan';
            elseif ($statusRand <= 90) $status = 'Diterima';
            else $status = 'Ditolak';

            $tanggal_diterima = null;
            $alasan_penolakan = null;
            if ($status == 'Diterima') {
                $tanggal_diterima = $tanggal_pengajuan->copy()->addDays(rand(1, 10));
            } elseif ($status == 'Ditolak') {
                $alasan_penolakan = $alasan_penolakan_profesional[array_rand($alasan_penolakan_profesional)];
            }
            $data[] = [
                'id_pengajuan' => $counter++,
                'id_mahasiswa' => $m->id_mahasiswa,
                'id_lowongan' => $l->id_lowongan,
                'tanggal_pengajuan' => $tanggal_pengajuan->format('Y-m-d'),
                'status' => $status,
                'tanggal_diterima' => $tanggal_diterima ? $tanggal_diterima->format('Y-m-d') : null,
                'alasan_penolakan' => $alasan_penolakan,
                'created_at' => $tanggal_pengajuan->format('Y-m-d H:i:s'),
                'updated_at' => $tanggal_diterima ? $tanggal_diterima->format('Y-m-d H:i:s') : $tanggal_pengajuan->format('Y-m-d H:i:s'),
            ];
        }

        DB::table('t_pengajuan_magang')->insert($data);
        $this->command->info('Berhasil menyeeder ' . count($data) . ' data pengajuan magang');
    }
}