<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LowonganResource\Pages;
use App\Filament\Resources\LowonganResource\RelationManagers;
use App\Models\Reference\BidangKeahlianModel;
use App\Models\Reference\DaerahMagangModel;
use App\Models\Reference\InsentifModel;
use App\Models\Reference\JenisMagangModel;
use App\Models\Reference\LokasiMagangModel;
use App\Models\Reference\LowonganMagangModel;
use App\Models\Reference\PeriodeModel;
use App\Models\Reference\PerusahaanModel;
use App\Models\Reference\ProvinsiModel;
use App\Models\Reference\WaktuMagangModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LowonganResource extends Resource
{
    protected static ?string $model = LowonganMagangModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-briefcase';
    protected static ?string $navigationLabel = 'Manajemen Lowongan';
    protected static ?string $slug = 'manajemen-lowongan';
    protected static ?string $modelLabel = 'Lowongan';
    protected static ?string $pluralModelLabel = 'Data Lowongan Magang';
    protected static ?string $navigationGroup = 'Magang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Lowongan')
                    ->schema([
                        Forms\Components\TextInput::make('judul_lowongan')
                            ->label('Judul Lowongan')
                            ->required()
                            ->maxLength(150),

                        Forms\Components\Select::make('id_perusahaan')
                            ->label('Perusahaan')
                            ->options(PerusahaanModel::all()->pluck('nama', 'id_perusahaan'))
                            ->searchable()
                            ->required(),

                        Forms\Components\RichEditor::make('deskripsi_lowongan')
                            ->label('Deskripsi Lowongan')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Detail Magang')
                    ->schema([
                        Forms\Components\Select::make('id_jenis_magang')
                            ->label('Jenis Magang')
                            ->options(JenisMagangModel::all()->pluck('nama_jenis_magang', 'id_jenis_magang'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('id_provinsi')
                            ->label('Provinsi')
                            ->options(ProvinsiModel::all()->pluck('nama_provinsi', 'id_provinsi'))
                            ->searchable()
                            ->reactive() // TRIGGER DROPDOWN DAERAH 
                            ->required(),
                            
                        Forms\Components\Select::make('id_daerah_magang')
                            ->label('Daerah (Kota/Kabupaten)')
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
                            ->disabled(fn (callable $get) => !$get('id_provinsi')) // Disable jika belum pilih provinsi
                            ->reactive(),

                        Forms\Components\Select::make('id_periode')
                            ->label('Periode')
                            ->options(PeriodeModel::all()->pluck('nama_periode', 'id_periode'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('id_waktu_magang')
                            ->label('Waktu Magang')
                            ->options(WaktuMagangModel::all()->pluck('waktu_magang', 'id_waktu_magang'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('id_insentif')
                            ->label('Insentif')
                            ->options(InsentifModel::all()->pluck('keterangan', 'id_insentif'))
                            ->searchable()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif',
                                'Selesai' => 'Selesai',
                            ])
                            ->default('Aktif')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Tanggal')
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal_posting')
                            ->label('Tanggal Posting')
                            ->default(now())
                            ->required(),

                        Forms\Components\DatePicker::make('batas_akhir_lamaran')
                            ->label('Batas Akhir Lamaran')
                            ->required()
                            ->afterOrEqual('tanggal_posting'),
                    ])->columns(2),

                Forms\Components\Section::make('Bidang Keahlian')
                    ->schema([
                        Forms\Components\CheckboxList::make('bidangKeahlian')
                            ->label('Pilih Bidang Keahlian')
                            ->relationship('bidangKeahlian', 'nama_bidang_keahlian')
                            ->options(BidangKeahlianModel::all()->pluck('nama_bidang_keahlian', 'id_bidang'))
                            ->columns(3)
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_lowongan')
                    ->label('Judul Lowongan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('perusahaan.nama')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenisMagang.nama_jenis_magang')
                    ->label('Jenis Magang')
                    ->sortable(),

                Tables\Columns\TextColumn::make('daerahMagang.namaLengkap')
                    ->label('Lokasi')
                    ->sortable(),

                Tables\Columns\TextColumn::make('batas_akhir_lamaran')
                    ->label('Batas Lamaran')
                    ->date()
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'Aktif',
                        'danger' => 'Selesai',
                    ]),
            ])
            ->emptyStateHeading('Tidak ada data lowongan')
            ->emptyStateIcon('heroicon-o-document-text')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Selesai' => 'Selesai',
                    ]),


                Tables\Filters\SelectFilter::make('id_perusahaan')
                    ->label('Perusahaan')
                    ->relationship('perusahaan', 'nama'),

                Tables\Filters\SelectFilter::make('id_jenis_magang')
                    ->label('Jenis Magang')
                    ->relationship('jenisMagang', 'nama_jenis_magang'),
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
            'index' => Pages\ListLowongans::route('/'),
            'create' => Pages\CreateLowongan::route('/create'),
            'view' => Pages\ViewLowongan::route('/{record}'),
            'edit' => Pages\EditLowongan::route('/{record}/edit'),
        ];
    }
}
