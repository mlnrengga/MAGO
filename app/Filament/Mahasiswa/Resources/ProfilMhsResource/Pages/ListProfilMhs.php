<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilMhs extends ListRecords
{
    protected static string $resource = ProfilMhsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
