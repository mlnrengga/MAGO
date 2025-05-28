<?php

namespace App\Filament\Widgets;

use App\Models\Auth\DosenPembimbingModel;
use App\Models\Reference\PenempatanMagangModel;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {    
        $totalMahasiswa = PenempatanMagangModel::distinct('id_mahasiswa')->count('id_mahasiswa');
        $totalDosen = DosenPembimbingModel::count();
        $rasio = $totalDosen > 0 ? round($totalMahasiswa / $totalDosen, 2) : 0;

        return [
            Stat::make('Total Mahasiswa Magang', $totalMahasiswa)
                ->description('10% increase')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Dosen Pembimbing', $totalDosen)
                ->description('Stable')
                ->descriptionIcon('heroicon-m-hand-thumb-up')
                ->color('primary'),
            Stat::make('Rasio Dosen:Mahasiswa', "1:$rasio")
                ->description('Optimal')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('warning'),
        ];
    }
}
