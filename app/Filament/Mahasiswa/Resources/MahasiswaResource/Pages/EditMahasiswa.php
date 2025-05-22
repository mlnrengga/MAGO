<?php

namespace App\Filament\Mahasiswa\Resources\MahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\MahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMahasiswa extends EditRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}