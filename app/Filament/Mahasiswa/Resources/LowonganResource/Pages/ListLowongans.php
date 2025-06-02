<?php

namespace App\Filament\Mahasiswa\Resources\LowonganResource\Pages;

use App\Filament\Mahasiswa\Resources\LowonganResource;
use App\Filament\Mahasiswa\Widgets\RekomendasiMagang;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListLowongans extends ListRecords
{
    protected static string $resource = LowonganResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            RekomendasiMagang::class,
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
