<?php

namespace App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditMonitoringaktivitasMagang extends EditRecord
{
    protected static string $resource = MonitoringaktivitasMagangResource::class;

    public function getHeading(): string
    {
        return 'Beri Feedback';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Simpan Feedback')
                ->icon('heroicon-o-check'),
                
            $this->getCancelFormAction()
                ->label('Batalkan')
                ->icon('heroicon-o-x-mark')
        ];
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->title('Feedback berhasil disimpan')
            ->success()
            ->send();
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Kembali ke Detail')
                ->color('gray'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}