<?php

namespace App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource\Pages;

use App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEvaluasiHasilMagang extends ViewRecord
{
    protected static string $resource = EvaluasiHasilMagangResource::class;

    public $penempatan;
    
    public function mount($record): void
    {
        parent::mount($record);
        
        // Ambil data penempatan untuk ditampilkan di form
        $this->penempatan = $this->record->penempatanMagang;
    }
}
