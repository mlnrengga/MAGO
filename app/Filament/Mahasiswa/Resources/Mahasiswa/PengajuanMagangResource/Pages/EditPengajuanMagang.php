<?php

namespace App\Filament\Mahasiswa\Resources\Mahasiswa\PengajuanMagangResource\Pages;

use App\Filament\Mahasiswa\Resources\Mahasiswa\PengajuanMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanMagang extends EditRecord
{
    protected static string $resource = PengajuanMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
