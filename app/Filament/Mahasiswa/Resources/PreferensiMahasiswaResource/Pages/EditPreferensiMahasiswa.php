<?php

namespace App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreferensiMahasiswa extends EditRecord
{
    protected static string $resource = PreferensiMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
