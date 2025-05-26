<?php

namespace App\Filament\Resources\ManajemenJenisMagangResource\Pages;

use App\Filament\Resources\ManajemenJenisMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManajemenJenisMagang extends CreateRecord
{
    protected static string $resource = ManajemenJenisMagangResource::class;

    public function getRedirectUrl(): string
    {
        return '/admin/manajemen-jenis-magang';
    }
}
