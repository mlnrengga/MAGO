<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Auth\AdminModel;
use App\Models\Auth\RoleModel;
use App\Models\UserModel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;

class AdminResource extends Resource
{
    protected static ?string $model = UserModel::class;
    protected static ?string $navigationLabel = 'Manajemen Admin';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    //     public static function form(Forms\Form $form): Forms\Form
    // {
    //     return $form->schema([
    //         Forms\Components\TextInput::make('nip')
    //             ->required(),

    //         Forms\Components\Select::make('id_role')
    //             ->label('Role')
    //             ->options(RoleModel::all()->pluck('nama_role', 'id_role'))
    //             ->required(),

    //         Forms\Components\TextInput::make('alamat')
    //             ->label('Alamat')
    //             ->afterStateHydrated(fn ($component, $state, $record) =>
    //                 $component->state($record?->user?->alamat)
    //             )
    //             ->dehydrated(false),

    //         Forms\Components\FileUpload::make('profile_picture')
    //             ->label('Foto Profil')
    //             ->image()
    //             ->directory('profile_pictures')
    //             ->afterStateHydrated(fn ($component, $state, $record) =>
    //                 $component->state($record?->user?->profile_picture)
    //             )
    //             ->dehydrated(false),
    //     ]);
    // }



    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([

            Forms\Components\TextInput::make('nip')
                ->label('NIP & NIM')
                ->required(),

            Forms\Components\Select::make('id_role')
                ->label('Role')
                ->options(RoleModel::all()->pluck('nama_role', 'id_role'))
                ->required(),

            Forms\Components\TextInput::make('nama')
                ->label('Nama Pengguna')
                ->required(),

            Forms\Components\TextInput::make('alamat')
                ->label('Alamat'),

            Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),

            Forms\Components\FileUpload::make('profile_picture')
                ->label('Foto Profil')
                ->image()
                ->directory('profile_pictures')
                ->disk('public'),

            Forms\Components\TextInput::make('no_telepon')   // <-- perbaiki di sini
                ->label('No Telepon')
                ->required(),
        ]);
    }



    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nip')->label('NIP'),
                Tables\Columns\TextColumn::make('nama')->label('Nama Pengguna'),
                Tables\Columns\TextColumn::make('role.nama_role')->label('Role'),
                Tables\Columns\TextColumn::make('no_telepon')->label('No Telepon'),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat'),



                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Foto Profil')
                    ->disk('public')
                    ->circular(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
