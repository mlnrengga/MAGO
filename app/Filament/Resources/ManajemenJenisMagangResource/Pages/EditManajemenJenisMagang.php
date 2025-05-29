<?php

namespace App\Filament\Resources\ManajemenJenisMagangResource\Pages;

use App\Filament\Resources\ManajemenJenisMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenJenisMagang extends EditRecord
{
    protected static string $resource = ManajemenJenisMagangResource::class;

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
