<?php

namespace App\Filament\Resources\PerusahaanResource\Pages;

use App\Filament\Resources\PerusahaanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class EditPerusahaan extends EditRecord
{
    protected static string $resource = PerusahaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('nama')->required()->maxLength(255),

            TextInput::make('alamat')->required()->maxLength(255),

            TextInput::make('no_telepon')->label('No Telepon')->tel()->required(),

            TextInput::make('email')->email()->required(),

            TextInput::make('admin_user_nama')
                ->label('Admin Penanggung Jawab')
                ->disabled()
                ->getStateUsing(fn ($get, $record) => optional(optional($record->admin)->user)->nama ?? '❌ TIDAK ADA')
                ->dehydrated(false),

            TextInput::make('website')->required(),
        ];
    }

    public function getRecord(): Model
    {
        return parent::getRecord()->loadMissing(['admin.user']);
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        parent::save($shouldRedirect, $shouldSendSavedNotification);

        Notification::make()
            ->title('Berhasil disimpan')
            ->body('Data perusahaan berhasil diperbarui.')
            ->success()
            ->send();
    }
}
