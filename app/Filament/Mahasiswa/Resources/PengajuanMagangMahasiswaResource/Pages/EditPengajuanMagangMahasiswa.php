<?php

namespace App\Filament\Mahasiswa\Resources\PengajuanMagangMahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\PengajuanMagangMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanMagangMahasiswa extends EditRecord
{
    protected static string $resource = PengajuanMagangMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
