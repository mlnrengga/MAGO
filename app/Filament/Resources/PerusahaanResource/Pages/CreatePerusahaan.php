<?php

namespace App\Filament\Resources\PerusahaanResource\Pages;

use App\Filament\Resources\PerusahaanResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePerusahaan extends CreateRecord
{
    protected static string $resource = PerusahaanResource::class;

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        parent::save($shouldRedirect, $shouldSendSavedNotification);

        // Notifikasi kustom
        Notification::make()
            ->title('Berhasil disimpan')
            ->body('Data perusahaan berhasil ditambahkan.')
            ->success()
            ->send();
    }
}
