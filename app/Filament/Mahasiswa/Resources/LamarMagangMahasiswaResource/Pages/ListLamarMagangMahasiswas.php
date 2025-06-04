<?php

namespace App\Filament\Mahasiswa\Resources\LamarMagangMahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\LamarMagangMahasiswaResource;
use App\Filament\Mahasiswa\Resources\LamarPekerjaanMahasiswaResource;
use App\Filament\Mahasiswa\Widgets\MahasiswaStatusPengajuanTable;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLamarMagangMahasiswas extends ListRecords
{
    protected static string $resource = LamarMagangMahasiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            MahasiswaStatusPengajuanTable::class,
        ];
    }

    protected function isTableRenderable(): bool
    {
        return false;
    }

    public function getTable(): \Filament\Tables\Table
    {
        $table = parent::getTable();

        $table->paginated(false);
        $table->striped(false);
        $table->defaultSort(null);
        $table->columns([]);
        $table->filters([]);
        $table->actions([]);
        $table->bulkActions([]);

        return $table;
    }
}
