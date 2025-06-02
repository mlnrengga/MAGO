<?php

namespace App\Filament\Mahasiswa\Resources\LowonganResource\Pages;

use App\Filament\Mahasiswa\Resources\LowonganResource;
use App\Filament\Mahasiswa\Widgets\RekomendasiMagang;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLowongan extends ViewRecord
{
    protected static string $resource = LowonganResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->url(function () {
                    return url()->previous();
                })
                ->color('gray')
                ->icon('heroicon-o-arrow-left'),
            Actions\Action::make('Ajukan Lamaran')
                ->label('Ajukan Lamaran')
                ->url(function () {
                    return url()->previous();
                })
                ->color('primary')
                ->icon('heroicon-o-paper-airplane'),
        ];
    }
    protected function mutateResourceBeforeRead(array $data): array 
    {
        // Make sure all relationships are properly loaded
        $this->record->load([
            'bidangKeahlian', 
            'perusahaan',
            'jenisMagang',
            'daerahMagang.provinsi',
            'waktuMagang',
            'insentif',
            'periode'
        ]);
        
        return $data;
    }
}