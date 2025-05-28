<?php

namespace App\Filament\Resources\KegiatanMagangResource\Pages;

use App\Filament\Resources\KegiatanMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKegiatanMagang extends ViewRecord
{
    protected static string $resource = KegiatanMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Status')
        ];
    }
}