<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class AdminRasioDosenMahasiswa extends ChartWidget
{
    protected static ?string $heading = '🍩 Rasio Dosen : Mahasiswa';
    protected static ?string $description = 'Rasio jumlah dosen pembimbing magang terhadap jumlah mahasiswa yang melakukan magang.';
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
                        '#0369A1', // Biru tua untuk dosen (profesional)
                        '#7DD3FC', // Biru muda untuk mahasiswa (energik)
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
