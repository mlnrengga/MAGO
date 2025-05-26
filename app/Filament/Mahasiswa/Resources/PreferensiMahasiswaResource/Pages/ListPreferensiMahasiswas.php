<?php

namespace App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPreferensiMahasiswas extends ListRecords
{
    protected static string $resource = PreferensiMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
