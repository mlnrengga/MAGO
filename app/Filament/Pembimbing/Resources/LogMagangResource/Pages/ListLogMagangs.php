<?php

namespace App\Filament\Pembimbing\Resources\LogMagangResource\Pages;

use App\Filament\Pembimbing\Resources\LogMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogMagangs extends ListRecords
{
    protected static string $resource = LogMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
