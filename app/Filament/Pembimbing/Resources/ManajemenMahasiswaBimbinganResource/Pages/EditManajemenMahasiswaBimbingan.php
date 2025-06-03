<?php

namespace App\Filament\Pembimbing\Resources\ManajemenMahasiswaBimbinganResource\Pages;

use App\Filament\Pembimbing\Resources\ManajemenMahasiswaBimbinganResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenMahasiswaBimbingan extends EditRecord
{
    protected static string $resource = ManajemenMahasiswaBimbinganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
