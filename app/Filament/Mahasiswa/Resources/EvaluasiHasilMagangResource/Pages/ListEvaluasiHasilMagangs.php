<?php

namespace App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource\Pages;

use App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluasiHasilMagangs extends ListRecords
{
    protected static string $resource = EvaluasiHasilMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
