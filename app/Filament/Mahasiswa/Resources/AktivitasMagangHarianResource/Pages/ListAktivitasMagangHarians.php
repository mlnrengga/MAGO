<?php

namespace App\Filament\Mahasiswa\Resources\AktivitasMagangHarianResource\Pages;

use App\Filament\Mahasiswa\Resources\AktivitasMagangHarianResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAktivitasMagangHarians extends ListRecords
{
    protected static string $resource = AktivitasMagangHarianResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
        ];
    }
    
    public function mount(): void
    {
        // panggil mount parent untuk inisialisasi
        parent::mount();
        
        // lalu proses filter
        $request = request();
        
        if ($request->filled('tableFilters')) {
            $filters = $request->get('tableFilters');
            
            if (isset($filters['filter_lowongan_magang'])) {
                $lowonganFilter = $filters['filter_lowongan_magang'];
                
                // Set filter values dari parameter URL
                foreach ($lowonganFilter as $key => $value) {
                    if ($key === 'dari_tanggal' || $key === 'sampai_tanggal') {
                        // Normalisasi format tanggal
                        try {
                            $date = Carbon::parse($value)->format('Y-m-d');
                            $this->tableFilters['filter_lowongan_magang'][$key] = $date;
                        } catch (\Exception $e) {
                            // Jika format tidak valid, gunakan nilai asli
                            $this->tableFilters['filter_lowongan_magang'][$key] = $value;
                        }
                    } else {
                        $this->tableFilters['filter_lowongan_magang'][$key] = $value;
                    }
                }
            }
        }
    }
}