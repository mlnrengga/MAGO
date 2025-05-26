<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdiResource\Pages;
use App\Filament\Resources\ProdiResource\RelationManagers;
use App\Models\Reference\ProdiModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdiResource extends Resource
{
    protected static ?string $model = ProdiModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_prodi'),
                TextInput::make('kode_prodi'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_prodi'),
                TextColumn::make('kode_prodi'),
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
            'index' => Pages\ListProdis::route('/'),
            'create' => Pages\CreateProdi::route('/create'),
            'edit' => Pages\EditProdi::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Manajemen Prodi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Manajemen Prodi';
    }

    public static function getModelLabel(): string
    {
        return 'Prodi';
    }
}
