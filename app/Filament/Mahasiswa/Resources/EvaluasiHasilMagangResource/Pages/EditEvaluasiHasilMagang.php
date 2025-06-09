<?php

namespace App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource\Pages;

use App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluasiHasilMagang extends EditRecord
{
    protected static string $resource = EvaluasiHasilMagangResource::class;
    
    // Menyimpan data penempatan magang
    public $penempatan;
    
    public function mount($record): void
    {
        parent::mount($record);
        
        // Ambil data penempatan untuk ditampilkan di form
        $this->penempatan = $this->record->penempatanMagang;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    // Override untuk mengubah breadcrumb "Edit"
    public function getBreadcrumb(): string
    {
        return 'Ubah Evaluasi';
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
