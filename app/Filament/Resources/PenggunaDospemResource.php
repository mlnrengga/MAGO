<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggunaDospemResource\Pages;
use App\Filament\Resources\PenggunaDospemResource\RelationManagers;
use App\Models\PenggunaDospem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenggunaDospemResource extends Resource
{
   protected static ?string $navigationLabel = 'Manajemen Dosen Pembimbing';
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
            'index' => Pages\ListPenggunaDospems::route('/'),
            'create' => Pages\CreatePenggunaDospem::route('/create'),
            'edit' => Pages\EditPenggunaDospem::route('/{record}/edit'),
        ];
    }
}
