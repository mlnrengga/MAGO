<?php

namespace App\Filament\Resources\AdminResource\Pages;

use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\AdminResource;

class ViewAdmin extends ViewRecord
{
    protected static string $resource = AdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record->load(['mahasiswa', 'admin', 'dosenPembimbing']);

        if ($record->id_role == 2 && $record->mahasiswa) {
            $data['extra']['nim'] = $record->mahasiswa->nim;
        }

        if (in_array($record->id_role, [1, 3])) {
            $data['extra']['nip'] = $record->admin?->nip ?? $record->dosenPembimbing?->nip;
        }

        return $data;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informasi Pengguna')
                ->schema([
                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Pengguna')
                        ->disabled(),

                    Forms\Components\TextInput::make('role.nama_role')
                        ->label('Role')
                        ->disabled(),

                    Forms\Components\TextInput::make('extra.nim')
                        ->label('NIM')
                        ->visible(fn ($get) => $get('id_role') == 2)
                        ->disabled(),

                    Forms\Components\TextInput::make('extra.nip')
                        ->label('NIP')
                        ->visible(fn ($get) => in_array($get('id_role'), [1, 3]))
                        ->disabled(),

                    Forms\Components\TextInput::make('alamat')
                        ->label('Alamat')
                        ->disabled(),

                    Forms\Components\TextInput::make('no_telepon')
                        ->label('No Telepon')
                        ->disabled(),

                    Forms\Components\FileUpload::make('profile_picture')
                        ->label('Foto Profil')
                        ->disabled()
                        ->image()
                        ->directory('profile_pictures')
                        ->disk('public'),
                ])->columns(2),
        ];
    }
}
