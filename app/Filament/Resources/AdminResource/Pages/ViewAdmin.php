<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;

class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdminResource::class;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informasi Akun')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->disabled(),

                    Forms\Components\Select::make('id_role')
                        ->label('Peran Pengguna')
                        ->options(\App\Models\Auth\RoleModel::pluck('nama_role', 'id_role'))
                        ->disabled(),

                    Forms\Components\TextInput::make('mahasiswa.nim')
                        ->label('NIM')
                        ->disabled()
                        ->visible(fn () => $this->record->id_role == 2)
                        ->getStateUsing(fn () => $this->record->mahasiswa?->nim ?? '-'),

                    Forms\Components\TextInput::make('admin.nip')
                        ->label('NIP Admin')
                        ->disabled()
                        ->visible(fn () => $this->record->id_role == 1)
                        ->getStateUsing(fn () => $this->record->admin?->nip ?? '-'),

                    Forms\Components\TextInput::make('dosenPembimbing.nip')
                        ->label('NIP Dosen Pembimbing')
                        ->disabled()
                        ->visible(fn () => $this->record->id_role == 3)
                        ->getStateUsing(fn () => $this->record->dosenPembimbing?->nip ?? '-'),

                    Forms\Components\TextInput::make('alamat')
                        ->label('Alamat')
                        ->disabled(),

                    Forms\Components\TextInput::make('no_telepon')
                        ->label('No Telepon')
                        ->disabled(),

                    Forms\Components\FileUpload::make('profile_picture')
                        ->label('Foto Profil')
                        ->disk('public')
                        ->directory('profile_pictures')
                        ->image()
                        ->rounded()
                        ->height(150)
                        ->width(150)
                        ->disabled(),
                ])
                ->columns(2),
        ];
    }
}
