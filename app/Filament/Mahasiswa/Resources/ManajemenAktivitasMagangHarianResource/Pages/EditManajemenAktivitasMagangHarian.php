<?php

namespace App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;

use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenAktivitasMagangHarian extends EditRecord
{
    protected static string $resource = ManajemenAktivitasMagangHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
