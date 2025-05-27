<?php

namespace App\Filament\Widgets;

use App\Models\Reference\PenempatanMagangModel;
use Filament\Widgets\ChartWidget;
// use Filament\Widgets\Widget;

class AdminStatistikMahasiswaMagangBulanan extends ChartWidget
{
    protected static ?string $heading = 'Grafik Mahasiswa Magang per Bulan';

    protected function getData(): array
    {
        // Inisialisasi array bulan (Januari-Desember)
        $labels = [];
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
            $data[$i] = 0;
        }

        // Query data jumlah mahasiswa per bulan
        $result = PenempatanMagangModel::selectRaw('MONTH(created_at) as bulan, COUNT(DISTINCT id_mahasiswa) as jumlah')
            ->whereYear('created_at', now()->year)
            ->groupBy('bulan')
            ->pluck('jumlah', 'bulan')
            ->toArray();

        // Masukkan data ke array sesuai bulan
        foreach ($result as $bulan => $jumlah) {
            $data[$bulan] = $jumlah;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Mahasiswa Magang',
                    'data' => array_values($data),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => '#60a5fa80',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Bisa 'bar', 'pie', dll
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true, // Y-axis mulai dari nol
                    'min' => 0,            // Pastikan tidak pernah minus
                ],
            ],
        ];
    }
}
