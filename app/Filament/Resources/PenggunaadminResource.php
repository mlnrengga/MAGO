<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggunaadminResource\Pages;
use App\Filament\Resources\PenggunaadminResource\RelationManagers;
use App\Models\Penggunaadmin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenggunaadminResource extends Resource
{
    protected static ?string $navigationLabel = 'Manajemen Admin';
    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?string $modelLabel = 'Manajemen - Pengguna';
    protected static ?string $pluralModelLabel = 'Data Pengguna';
    protected static ?string $navigationGroup = 'Pengguna & Mitra';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListPenggunaadmins::route('/'),
            'create' => Pages\CreatePenggunaadmin::route('/create'),
            'edit' => Pages\EditPenggunaadmin::route('/{record}/edit'),
        ];
    }
}
