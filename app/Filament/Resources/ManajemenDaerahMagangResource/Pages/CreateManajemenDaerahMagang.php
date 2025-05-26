<?php

namespace App\Filament\Resources\ManajemenDaerahMagangResource\Pages;

use App\Filament\Resources\ManajemenDaerahMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManajemenDaerahMagang extends CreateRecord
{
    protected static string $resource = ManajemenDaerahMagangResource::class;

    public function getRedirectUrl(): string
    {
        return '/admin/manajemen-daerah-magang';
    }
}
