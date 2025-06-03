<?php

namespace App\Filament\Pembimbing\Resources\ManajemenMahasiswaBimbinganResource\Pages;

use App\Filament\Pembimbing\Resources\ManajemenMahasiswaBimbinganResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemenMahasiswaBimbingans extends ListRecords
{
    protected static string $resource = ManajemenMahasiswaBimbinganResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
