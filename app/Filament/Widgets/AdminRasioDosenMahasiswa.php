<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class AdminRasioDosenMahasiswa extends ChartWidget
{
    protected static ?string $heading = 'Rasio Dosen : Mahasiswa';
    protected static ?string $maxHeight = '260px';

    protected function getData(): array
    {
        $totalMahasiswa = \App\Models\Reference\PenempatanMagangModel::distinct('id_mahasiswa')->count('id_mahasiswa');
        $totalDosen = \App\Models\Auth\DosenPembimbingModel::count();

        return [
            'datasets' => [
                [
                    'label' => 'Rasio',
                    'data' => [$totalDosen, $totalMahasiswa],
                    'backgroundColor' => [
                        '#3b82f6', // Warna dosen
                        '#f59e42', // Warna mahasiswa
                    ],
                ],
            ],
            'labels' => ['Dosen', 'Mahasiswa'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
