<?php

namespace App\Filament\Resources\KegiatanMagangResource\Pages;

use App\Filament\Resources\KegiatanMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKegiatanMagang extends EditRecord
{
    protected static string $resource = KegiatanMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
