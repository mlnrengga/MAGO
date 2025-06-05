<?php

namespace App\Filament\Resources\PerusahaanResource\Pages;

use App\Filament\Resources\PerusahaanResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class ViewPerusahaan extends ViewRecord
{
    protected static string $resource = PerusahaanResource::class;

    protected function getHeaderWidgets(): array
    {
        return [];
    }

    protected function getViewFormSchema(): array
    {
        return [
            TextInput::make('nama')->label('Nama')->disabled(),
            TextInput::make('alamat')->label('Alamat')->disabled(),
            TextInput::make('no_telepon')->label('No Telepon')->disabled(),
            TextInput::make('email')->label('Email')->disabled(),
            TextInput::make('website')->label('Website')->disabled(),

            // ====== Perubahan: Pakai getStateUsing untuk relasi admin.user.nama ======
            TextInput::make('admin_user_nama')
                ->label('Admin Penanggung Jawab')
                ->disabled()
                ->getStateUsing(fn ($record) => optional(optional($record->admin)->user)->nama ?? '❌ TIDAK ADA'),

            TextInput::make('debug_admin_id')
                ->label('ID Admin')
                ->default(fn($record) => $record->id_admin)
                ->disabled(),

            TextInput::make('debug_nama_admin')
                ->label('Nama Admin dari Relasi')
                ->default(fn($record) => optional(optional($record->admin)->user)->nama ?? '❌ TIDAK ADA')
                ->disabled(),
        ];
    }

    public function getRecord(): Model
    {
        // ====== Pastikan relasi admin.user dimuat ======
        return parent::getRecord()->loadMissing(['admin.user']);
    }
}
