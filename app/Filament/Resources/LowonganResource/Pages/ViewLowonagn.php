<?php

namespace App\Filament\Resources\LowonganResource\Pages;

use App\Filament\Resources\LowonganResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLowongan extends ViewRecord
{
    protected static string $resource = LowonganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}