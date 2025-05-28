<?php

namespace App\Filament\Resources\KegiatanMagangResource\Pages;

use App\Filament\Resources\KegiatanMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EditKegiatanMagang extends EditRecord
{
    protected static string $resource = KegiatanMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
