<?php

namespace App\Filament\Widgets;

use App\Models\Reference\PenempatanMagangModel;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class AdminStatistikMahasiswaMagangBulanan extends ChartWidget
{
    protected static ?string $heading = '📊 Grafik Mahasiswa Magang per Bulan';
    protected static ?string $description = 'Statistik jumlah mahasiswa magang yang sedang magang per bulan selama 12 bulan terakhir.';
    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $startDate = Carbon::now()->subMonths(11)->startOfMonth(); // 12 bulan window
        $endDate = Carbon::now()->endOfMonth();

        $labels = [];
        $monthlyData = [];

        // Setup labels & data 0
        $current = $startDate->copy();
        while ($current <= $endDate) {
            $key = $current->format('Y-m');
            $labels[$key] = $current->translatedFormat('M Y');
            $monthlyData[$key] = 0;
            $current->addMonth();
        }

        // Ambil semua penempatan, join ke data pengajuan, lowongan, periode, waktu_magang
        $penempatans = PenempatanMagangModel::query()
            ->with([
                'pengajuan.lowongan.periode',
                'pengajuan.lowongan.waktuMagang'
            ])
            ->get();

        // Untuk tiap penempatan, tentukan rentang aktif magangnya
        $studentsPerMonth = [];
        foreach ($penempatans as $penempatan) {
            // Lewatkan jika data relasi tidak lengkap
            if (
                empty($penempatan->pengajuan) ||
                empty($penempatan->pengajuan->lowongan) ||
                empty($penempatan->pengajuan->lowongan->periode) ||
                empty($penempatan->pengajuan->lowongan->waktuMagang)
            ) {
                continue;
            }

            $periode = $penempatan->pengajuan->lowongan->periode;
            $waktuMagang = $penempatan->pengajuan->lowongan->waktuMagang;

            // Penentuan tanggal mulai berdasarkan periode
            $periodeName = $periode->nama_periode;
            $tahun = intval(substr($periodeName, 0, 4));
            $isGanjil = stripos($periodeName, 'Ganjil') !== false;

            $tanggalMulai = $isGanjil
                ? Carbon::create($tahun, 7, 1)
                : Carbon::create($tahun + 1, 1, 1);

            // Durasi magang dalam bulan
            $durasiBulan = intval($waktuMagang->waktu_magang); // Pastikan isinya "6 Bulan" -> ambil angka saja
            if (!$durasiBulan) {
                // fallback: ambil angka dari string
                preg_match('/(\d+)/', $waktuMagang->waktu_magang, $match);
                $durasiBulan = isset($match[1]) ? intval($match[1]) : 6;
            }

            $tanggalSelesai = $tanggalMulai->copy()->addMonthsNoOverflow($durasiBulan)->subDay();

            // Jika status "Selesai" dan tanggal selesai lebih awal (jika ada field updated_at/selesai_at, bisa pakai)
            if ($penempatan->status == 'Selesai' && $penempatan->updated_at) {
                $updateAt = Carbon::parse($penempatan->updated_at);
                if ($updateAt->lt($tanggalSelesai)) {
                    $tanggalSelesai = $updateAt;
                }
            }

            // Loop setiap bulan dalam window, dan masukkan id_mahasiswa ke array bulan jika aktif di bulan itu
            $bulanAktif = $tanggalMulai->copy();
            while ($bulanAktif <= $tanggalSelesai) {
                $bulanKey = $bulanAktif->format('Y-m');
                // Hanya bulan dalam window
                if (array_key_exists($bulanKey, $monthlyData)) {
                    $studentsPerMonth[$bulanKey][$penempatan->id_mahasiswa] = true;
                }
                $bulanAktif->addMonth();
            }
        }

        // Hitung jumlah mahasiswa unik per bulan
        foreach ($monthlyData as $bulanKey => $v) {
            $monthlyData[$bulanKey] = isset($studentsPerMonth[$bulanKey])
                ? count($studentsPerMonth[$bulanKey])
                : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Mahasiswa Magang',
                    'data' => array_values($monthlyData),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#60a5fa80',
                    'fill' => true,
                ],
            ],
            'labels' => array_values($labels),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'min' => 0,
                ],
            ],
            'plugins' => [
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
        ];
    }
}