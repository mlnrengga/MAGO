<?php

namespace App\Filament\Mahasiswa\Resources\Mahasiswa\PengajuanMagangResource\Pages;

use App\Filament\Mahasiswa\Resources\Mahasiswa\PengajuanMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanMagangs extends ListRecords
{
    protected static string $resource = PengajuanMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
