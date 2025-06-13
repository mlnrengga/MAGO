<?php

namespace App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMonitoringaktivitasMagang extends ViewRecord
{
    protected static string $resource = MonitoringaktivitasMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->label('Beri Feedback'),
        ];
    }
}