<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\LamarMagangMahasiswaResource\Pages;
use App\Filament\Mahasiswa\Widgets\MahasiswaStatusPengajuanTable;
use App\Models\Reference\PengajuanMagangModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;

class LamarMagangMahasiswaResource extends Resource
{
    protected static ?string $model = PengajuanMagangModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-rocket-launch';
    protected static ?string $modelLabel = 'Lamaran Magang';
    protected static ?string $pluralModelLabel = 'Data Lamaran Magang';
    protected static ?string $navigationLabel = 'Lamaran Magang';
    protected static ?string $slug = 'lamaran-magang';
    protected static ?string $navigationGroup = 'Histori Lamaran';
    protected static ?int $navigationSort = 3;

    public static function getWidgets(): array
    {
        return [
            MahasiswaStatusPengajuanTable::class
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_lowongan')
                    ->relationship('lowongan', 'judul_lowongan', fn($query) => $query->where('status', 'Aktif'))
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Lowongan Magang')
                    ->live()
                    ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Components\Component $component) {
                        if (!$state) {
                            $component->getContainer()->getComponent('lowongan_preview')->schema([]);
                            return;
                        }

                        $lowongan = \App\Models\Reference\LowonganMagangModel::find($state);
                        if (!$lowongan) return;

                        $component->getContainer()->getComponent('lowongan_preview')->schema([
                            Forms\Components\Placeholder::make('judul_lowongan')
                                ->label('Judul Lowongan')
                                ->content($lowongan->judul_lowongan),

                            Forms\Components\Placeholder::make('perusahaan')
                                ->label('Perusahaan')
                                ->content($lowongan->perusahaan->nama ?? '-'),

                            Forms\Components\Placeholder::make('jenis_magang')
                                ->label('Jenis Magang')
                                ->content($lowongan->jenisMagang->nama_jenis_magang ?? '-'),

                            Forms\Components\Placeholder::make('lokasi')
                                ->label('Lokasi')
                                ->content(($lowongan->daerahMagang->provinsi->nama_provinsi ?? '-') .
                                    ', ' . ($lowongan->daerahMagang->namaLengkap ?? '-')),

                            Forms\Components\Placeholder::make('periode')
                                ->label('Periode')
                                ->content($lowongan->periode->nama_periode ?? '-'),

                            Forms\Components\Placeholder::make('waktu_magang')
                                ->label('Waktu Magang')
                                ->content($lowongan->waktuMagang->waktu_magang ?? '-'),

                            Forms\Components\Placeholder::make('insentif')
                                ->label('Insentif')
                                ->content($lowongan->insentif->keterangan ?? '-'),

                            Forms\Components\Placeholder::make('batas_lamaran')
                                ->label('Batas Akhir Lamaran')
                                ->content($lowongan->batas_akhir_lamaran ? $lowongan->batas_akhir_lamaran->format('d F Y') : '-'),

                            Forms\Components\Placeholder::make('status')
                                ->label('Status')
                                ->content($lowongan->status ? ucfirst($lowongan->status) : '-'),

                            Forms\Components\Placeholder::make('deskripsi')
                                ->label('Deskripsi')
                                ->content(new \Illuminate\Support\HtmlString($lowongan->deskripsi_lowongan ?? '-'))
                                ->columnSpanFull(),
                        ])->columns(2);
                    }),

                Forms\Components\Section::make('Preview Lowongan')
                    ->schema([])
                    ->visible(fn(Forms\Get $get) => (bool) $get('id_lowongan'))
                    ->key('lowongan_preview'),

                Forms\Components\DatePicker::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->default(now())
                    ->required(),

                Forms\Components\Hidden::make('status')
                    ->default('Diajukan'),

                Forms\Components\Hidden::make('id_mahasiswa')
                    ->default(fn() => auth()->user()->mahasiswa->id_mahasiswa),
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
            'index' => Pages\ListLamarMagangMahasiswas::route('/'),
            'create' => Pages\CreateLamarMagangMahasiswa::route('/create'),
        ];
    }
}
