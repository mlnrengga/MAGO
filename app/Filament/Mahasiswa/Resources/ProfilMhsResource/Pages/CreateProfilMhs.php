<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfilMhs extends CreateRecord
{
    protected static string $resource = ProfilMhsResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
