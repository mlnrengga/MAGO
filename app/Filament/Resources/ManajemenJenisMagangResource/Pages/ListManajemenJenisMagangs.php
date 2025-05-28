<?php

namespace App\Filament\Resources\ManajemenJenisMagangResource\Pages;

use App\Filament\Resources\ManajemenJenisMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemenJenisMagangs extends ListRecords
{
    protected static string $resource = ManajemenJenisMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
