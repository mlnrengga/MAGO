<?php

namespace App\Filament\Mahasiswa\Resources\PengajuanMagangMandiriResource\Pages;

use App\Filament\Mahasiswa\Resources\PengajuanMagangMandiriResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanMagangMandiris extends ListRecords
{
    protected static string $resource = PengajuanMagangMandiriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajukan Magang Mandiri')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('Ajukan Magang Mandiri Baru'),
        ];
    }
}
