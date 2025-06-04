<?php

namespace App\Filament\Mahasiswa\Resources\PengajuanMagangMandiriResource\Pages;

use App\Filament\Mahasiswa\Resources\PengajuanMagangMandiriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanMagangMandiri extends EditRecord
{
    protected static string $resource = PengajuanMagangMandiriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
