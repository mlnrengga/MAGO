<?php

namespace App\Filament\Mahasiswa\Resources\LamarMagangMahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\LamarMagangMahasiswaResource;
use App\Filament\Mahasiswa\Widgets\MahasiswaStatusPengajuanTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLamarMagangMahasiswas extends ListRecords
{
    protected static string $resource = LamarMagangMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Lamar Magang Baru')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Lamar Magang Baru'),
        ];
    }
}
