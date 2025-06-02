<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Perusahaan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Models\Reference\PerusahaanModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PerusahaanResource\Pages;
use App\Filament\Resources\PerusahaanResource\RelationManagers;

class PerusahaanResource extends Resource
{
    protected static ?string $model = PerusahaanModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-office';
    protected static ?string $navigationLabel = 'Perusahaan Mitra';
    protected static ?string $navigationGroup = 'Pengguna & Mitra';
    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'menajemen-perusahan';
    protected static ?string $modelLabel = 'Lowongan';
    protected static ?string $pluralModelLabel = 'Data Lowongan Magang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),

                TextInput::make('no_telepon')
                    ->label('No Telepon')
                    ->tel()
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),

                Select::make('id_admin')
                    ->label('Admin Penanggung Jawab')
                    ->relationship('admin', 'nip')
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('website')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable(),
                TextColumn::make('alamat')->limit(50),
                TextColumn::make('no_telepon'),
                TextColumn::make('email'),
                TextColumn::make('admin.nip')->label('Admin'),
                TextColumn::make('website')  // Fixed case to match database column
                    ->label('Website'),     // Proper label for display
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),  // Added view action
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerusahaans::route('/'),
            'create' => Pages\CreatePerusahaan::route('/create'),
              'view' => Pages\ViewPerusahaan::route('/{record}'),
            'edit' => Pages\EditPerusahaan::route('/{record}/edit'),
        ];
    }
}