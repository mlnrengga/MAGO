<?php

namespace App\Filament\Resources\PenggunaadminResource\Pages;

use App\Filament\Resources\PenggunaadminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenggunaadmins extends ListRecords
{
    protected static string $resource = PenggunaadminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
