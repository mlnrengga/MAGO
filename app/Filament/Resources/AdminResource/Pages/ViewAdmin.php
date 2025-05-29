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

    // protected function getFormSchema(): array
    // {
    //     return [
    //         Forms\Components\Section::make('Informasi Pengguna')
    //             ->schema([
    //                 Forms\Components\TextInput::make('nama')
    //                     ->label('Nama Pengguna')
    //                     ->disabled(),
                        
    //                 // Forms\Components\TextInput::make('nim')
    //                 //     ->label('NIM')
    //                 //     ->disabled()
    //                 //     ->visible(fn() => $this->record->id_role == 2),
                        
    //                 Forms\Components\TextInput::make('no_telepon')
    //                     ->label('No Telepon')
    //                     ->disabled(),
                        
    //                 Forms\Components\TextInput::make('role.nama_role')
    //                     ->label('Role')
    //                     ->disabled(),
                        
    //                 Forms\Components\TextInput::make('alamat')
    //                     ->label('Alamat')
    //                     ->disabled(),
                        
    //                 Forms\Components\FileUpload::make('profile_picture')
    //                     ->label('Foto Profil')
    //                     ->disabled()
    //                     ->image()
    //                     ->directory('profile_pictures')
    //                     ->disk('public'),
    //             ])->columns(2),
    //     ];
    // }
}