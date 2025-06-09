<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdiResource\Pages;
use App\Filament\Resources\ProdiResource\RelationManagers;
use App\Models\Reference\ProdiModel;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
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

    protected static ?string $navigationIcon = 'heroicon-s-building-library';
    protected static ?string $navigationLabel = 'Program Studi';
    protected static ?string $pluralModelLabel = 'Data Program Studi';
    protected static ?string $modelLabel = 'Program Studi';
    protected static ?string $navigationGroup = 'Data Referensi';
    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Buat Program Studi Baru')
                    ->schema([
                        TextInput::make('nama_prodi')
                            ->label('Nama Program Studi'),
                        TextInput::make('kode_prodi')
                            ->label('Kode Program Studi')
                            ->placeholder('Contoh: D4-TI'),
                    ])
            ]);
    }

    public static function infolistSchema(): array
    {
        return [
            Section::make('Data Program Studi')
                ->schema([
                    Placeholder::make('nama_prodi')
                        ->label('Nama Program Studi')
                        ->content(fn ($record) => $record->nama_prodi),
                    
                    Placeholder::make('kode_prodi')
                        ->label('Kode Program Studi')
                        ->content(fn ($record) => $record->kode_prodi),
                    
                    Placeholder::make('jumlah_mahasiswa')
                        ->label('Jumlah Mahasiswa')
                        ->content(function ($record) {
                            $count = $record->mahasiswa()->count();
                            return $count . ' mahasiswa';
                        }),
                ])
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_prodi')
                    ->label('Nama Program Studi')
                    ->searchable(),
                TextColumn::make('kode_prodi')
                    ->label('Kode Program Studi')
                    ->searchable(),
                TextColumn::make('mahasiswa_count')
                    ->label('Jumlah Mahasiswa')
                    ->getStateUsing(fn ($record) => $record->mahasiswa()->count())
                    ->formatStateUsing(fn ($state) => ($state ?? 0) . ' mahasiswa')
                    ->badge()
                    ->color('success'), 
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->form(static::infolistSchema()),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Tidak ada data program studi yang ditemukan')
            ->emptyStateDescription('Silakan buat data program studi baru.');
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
}
