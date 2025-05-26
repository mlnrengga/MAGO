<?php

namespace App\Filament\Resources\ManajemenDaerahMagangResource\Pages;

use App\Filament\Resources\ManajemenDaerahMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemenDaerahMagangs extends ListRecords
{
    protected static string $resource = ManajemenDaerahMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
