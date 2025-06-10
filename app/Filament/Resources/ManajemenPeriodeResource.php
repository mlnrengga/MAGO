<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManajemenPeriodeResource\Pages;
use App\Filament\Resources\ManajemenPeriodeResource\RelationManagers;
use App\Models\ManajemenPeriode;
use App\Models\Reference\PeriodeModel;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ManajemenPeriodeResource extends Resource
{
    protected static ?string $model = PeriodeModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-clock';
    protected static ?string $navigationLabel = 'Periode';
    protected static ?string $slug = 'manajemen-periode';
    protected static ?string $modelLabel = 'Manajemen - Periode';
    protected static ?string $pluralModelLabel = 'Data Periode';
    protected static ?string $navigationGroup = 'Data Referensi';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_periode')
                    ->label('Nama Periode')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_periode')
                    ->label('ID')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_periode')
                    ->label('Nama Periode')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListManajemenPeriodes::route('/'),
            'create' => Pages\CreateManajemenPeriode::route('/create'),
            'edit' => Pages\EditManajemenPeriode::route('/{record}/edit'),
        ];
    }
}
