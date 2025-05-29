<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\Pages;
use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\RelationManagers;
use App\Models\Pivot\PreferensiMahasiswaModel;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PreferensiMahasiswaResource extends Resource
{
    protected static ?string $model = PreferensiMahasiswaModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('id_bidang')
                    ->label('Bidang Keahlian')
                    ->relationship('bidangKeahlian', 'nama_bidang_keahlian')
                    ->required()
                    ->native(false),

                TextInput::make('ranking_bidang')
                    ->label('Ranking Bidang')
                    ->numeric()
                    ->required(),

                Select::make('id_lokasi_magang')
                    ->label('Lokasi Magang')
                    ->relationship('lokasiMagang', 'nama_lokasi')
                    ->required()
                    ->native(false),

                TextInput::make('ranking_lokasi')
                    ->label('Ranking Lokasi')
                    ->numeric()
                    ->required(),

                Select::make('id_jenis_magang')
                    ->label('Jenis Magang')
                    ->relationship('jenisMagang', 'nama_jenis_magang')
                    ->required()
                    ->native(false),

                TextInput::make('ranking_jenis')
                    ->label('Ranking Jenis')
                    ->numeric()
                    ->required(),

                Select::make('id_insentif')
                    ->label('Insentif')
                    ->relationship('insentif', 'keterangan')
                    ->required()
                    ->native(false),

                TextInput::make('ranking_insentif')
                    ->label('Ranking Insentif')
                    ->numeric()
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // TextColumn::make('id_bidang_keahlian'),
                // TextColumn::make('ranking_bidang'),
                // TextColumn::make('id_lokasi_magang'),
                // TextColumn::make('ranking_lokasi'),
                // TextColumn::make('id_jenis_magang'),
                // TextColumn::make('ranking_jenis'),
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
            'index' => Pages\ListPreferensiMahasiswas::route('/'),
            'create' => Pages\CreatePreferensiMahasiswa::route('/create'),
            'edit' => Pages\EditPreferensiMahasiswa::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Manajemen Akun & Profil';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Manajemen Akun & Profil';
    }

    public static function getModelLabel(): string
    {
        return 'Preferensi';
    }
}
