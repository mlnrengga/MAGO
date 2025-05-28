<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProfilMhs extends EditRecord
{
    protected static string $resource = ProfilMhsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
