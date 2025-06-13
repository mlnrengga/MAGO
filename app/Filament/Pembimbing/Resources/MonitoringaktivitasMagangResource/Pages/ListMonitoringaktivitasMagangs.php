<?php

namespace App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonitoringaktivitasMagangs extends ListRecords
{
    protected static string $resource = MonitoringaktivitasMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}