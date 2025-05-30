<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\Pages;
use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\RelationManagers;
use App\Models\Reference\PreferensiMahasiswaModel;
use App\Models\Reference\BidangKeahlianModel;
use App\Models\Reference\DaerahMagangModel;
use App\Models\Reference\InsentifModel;
use App\Models\Reference\JenisMagangModel;
use App\Models\Reference\LokasiMagangModel;
use App\Models\Reference\ProvinsiModel;
use App\Models\Reference\WaktuMagangModel;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
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
use Illuminate\Support\Facades\Auth;

class PreferensiMahasiswaResource extends Resource
{
    protected static ?string $model = PreferensiMahasiswaModel::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('id_mahasiswa', Auth::user()->id_mahasiswa);
    }

    public static function canCreate(): bool
    {
        return !static::getModel()::where('id_mahasiswa', Auth::user()->id_mahasiswa)->exists();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil ID mahasiswa dari user login
        $data['id_mahasiswa'] = auth()->user()->mahasiswa->id_mahasiswa;

        return $data;
    }

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Bidang Keahlian')
                    ->schema([
                        CheckboxList::make('bidangKeahlian')
                            ->label('Pilih Bidang Keahlian')
                            ->relationship('bidangKeahlian', 'nama_bidang_keahlian')
                            ->options(BidangKeahlianModel::all()->pluck('nama_bidang_keahlian', 'id_bidang'))
                            ->columns(4)
                            ->required(),

                        Group::make()
                            ->label('Ranking Bidang Keahlian')
                            ->schema(function (Forms\Get $get) {
                                $schemas = [];

                                foreach ($get('bidangKeahlian') ?? [] as $id_bidang) {
                                    $namaBidang = BidangKeahlianModel::find($id_bidang)?->nama_bidang_keahlian ?? 'Unknown';
                                    $schemas[] = Select::make("ranking_$id_bidang")
                                        ->label("Ranking untuk $namaBidang")
                                        ->options([
                                            1 => '1',
                                            2 => '2',
                                            3 => '3',
                                            4 => '4',
                                            5 => '5',
                                        ])
                                        ->required();
                                }

                                return $schemas;
                            }),
                    ]),

                Section::make('Daerah Magang')
                    ->schema([
                        Select::make('id_provinsi')
                            ->label('Pilih Provinsi')
                            ->options(ProvinsiModel::all()->pluck('nama_provinsi', 'id_provinsi'))
                            ->searchable()
                            ->native(false)
                            ->reactive() // TRIGGER DROPDOWN DAERAH 
                            ->required(),

                        Select::make('id_daerah_magang')
                            ->label('Pilih Daerah (Kota/Kabupaten)')
                            ->options(function (callable $get) {
                                $provinsiId = $get('id_provinsi');
                                if (!$provinsiId) {
                                    return [];
                                }
                                return DaerahMagangModel::where('id_provinsi', $provinsiId)
                                    ->get()
                                    ->pluck('namaLengkap', 'id_daerah_magang');
                            })
                            ->searchable()
                            ->required()
                            ->disabled(fn(callable $get) => !$get('id_provinsi')) // Disable jika belum pilih provinsi
                            ->native(false)
                            ->reactive(),

                        Select::make('ranking_daerah')
                            ->label('Ranking Daerah')
                            ->options([
                                1 => '1',
                                2 => '2',
                                3 => '3',
                                4 => '4',
                                5 => '5',
                            ])
                            ->required(),
                    ]),

                Section::make('Jenis Magang')
                    ->schema([
                        CheckboxList::make('jenisMagang')
                            ->label('Pilih Jenis Magang')
                            ->options(JenisMagangModel::all()->pluck('nama_jenis_magang', 'id_jenis_magang'))
                            ->columns(3)
                            ->reactive()
                            ->required(),

                        Group::make()
                            ->label('Ranking Jenis Magang')
                            ->schema(function (Forms\Get $get) {
                                $schemas = [];

                                foreach ($get('jenisMagang') ?? [] as $id_jenis_magang) {
                                    $namaJenis = JenisMagangModel::find($id_jenis_magang)?->nama_jenis_magang ?? 'Unknown';
                                    $schemas[] = Select::make("ranking_$id_jenis_magang")
                                        ->label("Ranking untuk $namaJenis")
                                        ->options([
                                            1 => '1',
                                            2 => '2',
                                            3 => '3',
                                            4 => '4',
                                            5 => '5',
                                        ])
                                        ->required();
                                }

                                return $schemas;
                            }),
                    ]),




                Section::make('Insentif Magang')
                    ->schema([
                        Select::make('id_insentif')
                            ->label('Pilih Insentif')
                            ->options(InsentifModel::all()->pluck('keterangan', 'id_insentif'))
                            ->searchable()
                            ->required()
                            ->native(false),

                        Select::make('ranking_insentif')
                            ->label('Ranking Insentif')
                            ->options([
                                1 => '1',
                                2 => '2',
                                3 => '3',
                                4 => '4',
                                5 => '5',
                            ])
                            ->required(),
                    ]),

                Section::make('Waktu Magang')
                    ->schema([
                        Select::make('id_waktu_magang')
                            ->label('Pilih Waktu Magang')
                            ->options(WaktuMagangModel::all()->pluck('waktu_magang', 'id_waktu_magang'))
                            ->searchable()
                            ->native(false),

                        Select::make('ranking_waktu_magang')
                            ->label('Ranking Waktu Magang')
                            ->options([
                                1 => '1',
                                2 => '2',
                                3 => '3',
                                4 => '4',
                                5 => '5',
                            ])
                            ->required(),
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bidangKeahlian')
                    ->label('Bidang Keahlian')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->bidangKeahlian->map(
                            fn($bidang) =>
                            "{$bidang->nama_bidang_keahlian} (R: {$bidang->pivot->ranking_bidang})"
                        )->implode(', ')
                    ),
                // TextColumn::make('bidangKeahlian.nama_bidang_keahlian')
                //     ->label('Bidang Keahlian'),
                // TextColumn::make('ranking_bidang')
                //     ->label('Ranking Bidang'),
                TextColumn::make('daerahMagang.nama_daerah')
                    ->label('Daerah Magang'),
                TextColumn::make('ranking_daerah')
                    ->label('Ranking Daerah'),

                TextColumn::make('jenisMagang')
                    ->label('Jenis Magang')
                    ->formatStateUsing(
                        fn($record) =>
                        $record->jenisMagang->map(
                            fn($jenis) =>
                            "{$jenis->nama_jenis_magang} (R: {$jenis->pivot->ranking_jenis_magang})"
                        )->implode(', ')
                    ),
                // TextColumn::make('jenisMagang.nama_jenis_magang')
                //     ->label('Jenis Magang'),
                // TextColumn::make('ranking_jenis')
                //     ->label('Ranking Jenis'),
                TextColumn::make('insentif.keterangan')
                    ->label('Insentif'),
                TextColumn::make('ranking_insentif')
                    ->label('Ranking Insentif'),
                TextColumn::make('waktuMagang.waktu_magang')
                    ->label('Waktu Magang'),
                TextColumn::make('ranking_waktu_magang')
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
