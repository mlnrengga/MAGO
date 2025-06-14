<?php

namespace App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateMonitoringaktivitasMagang extends CreateRecord
{
    protected static string $resource = MonitoringaktivitasMagangResource::class;

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Feedback berhasil ditambahkan')
            ->success()
            ->send();
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return null;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}