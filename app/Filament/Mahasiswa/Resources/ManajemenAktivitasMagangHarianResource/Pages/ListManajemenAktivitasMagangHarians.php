<?php

namespace App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;

use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource;
use App\Filament\Widgets\MahasiswaPilihPenempatanMagang;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajemenAktivitasMagangHarians extends ListRecords
{
    protected static string $resource = ManajemenAktivitasMagangHarianResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            // MahasiswaPilihPenempatanMagang::make(),
        ];
    }

    protected function getHeaderActions(): array
    {
        if (!request('penempatanId')) {
            return [];
        }
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function ($data) {
                    $data['id_penempatan'] = request('penempatanId');
                    return $data;
                }),
        ];
    }
}
