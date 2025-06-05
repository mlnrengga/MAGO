<?php

namespace App\Filament\Resources\PenggunaMahasiswaResource\Pages;

use App\Filament\Resources\PenggunaMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenggunaMahasiswas extends ListRecords
{
    protected static string $resource = PenggunaMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
