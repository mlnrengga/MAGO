<?php

namespace App\Filament\Resources\ManajemenDaerahMagangResource\Pages;

use App\Filament\Resources\ManajemenDaerahMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenDaerahMagang extends EditRecord
{
    protected static string $resource = ManajemenDaerahMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
