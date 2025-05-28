<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\Pages;
use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\RelationManagers;
use App\Models\Pivot\PreferensiMahasiswaModel;
use App\Models\Reference\BidangKeahlianModel;
use App\Models\Reference\DaerahMagangModel;
use App\Models\Reference\InsentifModel;
use App\Models\Reference\JenisMagangModel;
use App\Models\Reference\LokasiMagangModel;
use App\Models\Reference\WaktuMagangModel;
use Filament\Forms;
use Filament\Forms\Components\Section;
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

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Bidang Keahlian')
                ->schema([
                Select::make('id_bidang')
                    ->label('Bidang Keahlian')
                    ->options(BidangKeahlianModel::all()->pluck('nama_bidang_keahlian', 'id_bidang'))
                    ->searchable()
                    ->multiple()
                    ->required()
                    ->native(false),

                TextInput::make('ranking_bidang')
                    ->label('Ranking Bidang')
                    ->numeric()
                    ->required(),
                ]),

                Section::make('Daerah Magang')
                ->schema([
                Select::make('id_daerah_magang')
                    ->label('Daerah Magang')
                    ->options(DaerahMagangModel::all()->pluck('nama_daerah', 'id_daerah_magang'))
                    ->searchable()
                    ->multiple()
                    ->required()
                    ->native(false),

                TextInput::make('ranking_lokasi')
                    ->label('Ranking Lokasi')
                    ->numeric()
                    ->required(),
                ]),

                Section::make('Jenis Magang')
                ->schema([
                Select::make('id_jenis_magang')
                    ->label('Jenis Magang')
                    ->options(JenisMagangModel::all()->pluck('nama_jenis_magang', 'id_jenis_magang'))
                    ->searchable()
                    ->native(false),

                TextInput::make('ranking_jenis')
                    ->label('Ranking Jenis')
                    ->numeric()
                    ->required(),
                ]),

                Section::make('Insentif Magang')
                ->schema([
                Select::make('id_insentif')
                    ->label('Insentif')
                    ->options(InsentifModel::all()->pluck('keterangan', 'id_insentif'))
                    ->searchable()
                    ->required()
                    ->native(false),

                TextInput::make('ranking_insentif')
                    ->label('Ranking Insentif')
                    ->numeric()
                    ->required(),
                ]),

                Section::make('Waktu Magang')
                ->schema([
                Select::make('id_waktu_magang')
                    ->label('Waktu Magang')
                    ->options(WaktuMagangModel::all()->pluck('waktu_magang', 'id_waktu_magang'))
                    ->searchable()
                    ->native(false),

                TextInput::make('ranking_waktu')
                    ->label('Ranking Waktu Magang')
                    ->numeric()
                    ->required(),
                ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bidangKeahlian.nama_bidang_keahlian')
                    ->label('Bidang Keahlian'),
                TextColumn::make('ranking_bidang')
                    ->label('Ranking Bidang'),
                TextColumn::make('lokasiMagang.nama_lokasi')
                    ->label('Lokasi Magang'),
                TextColumn::make('ranking_lokasi')
                    ->label('Ranking Lokasi'),
                TextColumn::make('jenisMagang.nama_jenis_magang')
                    ->label('Jenis Magang'),
                TextColumn::make('ranking_jenis')
                    ->label('Ranking Jenis'),
                TextColumn::make('insentif.keterangan')
                    ->label('Insentif'),
                TextColumn::make('ranking_insentif')
                    ->label('Ranking Insentif'),
                TextColumn::make('waktuMagang.waktu_magang')
                    ->label('Waktu Magang'),
                TextColumn::make('ranking_waktu')
                    ->label('Ranking Waktu'),
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
        return 'Manajemen Preferensi';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Preferensi Mahasiswa';
    }

    public static function getModelLabel(): string
    {
        return 'Preferensi';
    }
}
