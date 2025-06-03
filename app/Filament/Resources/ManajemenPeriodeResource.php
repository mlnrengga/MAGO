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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManajemenPeriodeResource extends Resource
{
    protected static ?string $model = PeriodeModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $pluralModelLabel = 'Manajemen Periode';
    protected static ?string $navigationLabel = 'Manajemen Periode';

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
