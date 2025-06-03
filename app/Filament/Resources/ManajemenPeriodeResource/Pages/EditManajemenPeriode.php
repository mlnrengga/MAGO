<?php

namespace App\Filament\Resources\ManajemenPeriodeResource\Pages;

use App\Filament\Resources\ManajemenPeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenPeriode extends EditRecord
{
    protected static string $resource = ManajemenPeriodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
