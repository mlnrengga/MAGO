<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ];
    }

   protected function getFormSchema(): array
{
    $record = $this->record->load(['mahasiswa', 'admin', 'dosenPembimbing']);

    $nimOrNip = '';
    if ($record->id_role == 2 && $record->mahasiswa) {
        $nimOrNip = $record->mahasiswa->nim;
    } elseif ($record->id_role == 1 && $record->admin) {
        $nimOrNip = $record->admin->nip;
    } elseif ($record->id_role == 3 && $record->dosenPembimbing) {
        $nimOrNip = $record->dosenPembimbing->nip;
    }

    return [
        \Filament\Forms\Components\Section::make('Informasi Pengguna')
            ->schema([
                \Filament\Forms\Components\TextInput::make('nama')
                    ->label('Nama Pengguna')
                    ->disabled(),

                \Filament\Forms\Components\TextInput::make('role.nama_role')
                    ->label('Role')
                    ->disabled(),

                \Filament\Forms\Components\TextInput::make('no_telepon')
                    ->label('No Telepon')
                    ->disabled(),

                \Filament\Forms\Components\TextInput::make('alamat')
                    ->label('Alamat')
                    ->disabled(),

                \Filament\Forms\Components\Placeholder::make('nim_or_nip')
                    ->label($record->id_role == 2 ? 'NIM' : 'NIP')
                    ->content($nimOrNip),

                \Filament\Forms\Components\FileUpload::make('profile_picture')
                    ->label('Foto Profil')
                    ->disk('public')
                    ->directory('profile_pictures')
                    ->image()
                    ->disabled(),
            ])->columns(2),
    ];
}
}

