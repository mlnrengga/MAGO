<?php

namespace App\Filament\Resources\PenggunaMahasiswaResource\Pages;

use App\Filament\Resources\PenggunaMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenggunaMahasiswa extends EditRecord
{
    protected static string $resource = PenggunaMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
