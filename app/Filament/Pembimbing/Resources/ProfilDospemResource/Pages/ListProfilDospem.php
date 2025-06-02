<?php

namespace App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;

use App\Filament\Pembimbing\Resources\ProfilDospemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProfilDospems extends ListRecords
{
    protected static string $resource = ProfilDospemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
