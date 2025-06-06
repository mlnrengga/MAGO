<?php

namespace App\Filament\Resources\PenggunaMahasiswaResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PenggunaMahasiswaResource;

class EditPenggunaMahasiswa extends EditRecord
{
    protected static string $resource = PenggunaMahasiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
