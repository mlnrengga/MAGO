<?php

namespace App\Filament\Resources\ManajemenPeriodeResource\Pages;

use App\Filament\Resources\ManajemenPeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemenPeriodes extends ListRecords
{
    protected static string $resource = ManajemenPeriodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Periode Baru'), 
        ];
    }
}
