<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanMagangResource\Pages;
use App\Filament\Resources\KegiatanMagangResource\RelationManagers;
use App\Models\KegiatanMagang;
use App\Models\Reference\PengajuanMagangModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Console\View\Components\Info;

class KegiatanMagangResource extends Resource
{
    protected static ?string $model = PengajuanMagangModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-check';
    protected static ?string $navigationLabel = 'Manajemen Kegiatan Magang';
    protected static ?string $slug = 'kegiatan-magang';
    protected static ?string $modelLabel = 'Pengajuan Magang';
    protected static ?string $pluralModelLabel = 'Data Pengajuan Magang';
    protected static ?string $navigationGroup = 'Magang';

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Mahasiswa')
                    ->schema([
                        Infolists\Components\TextEntry::make('mahasiswa.user.nama')
                            ->label('Nama Mahasiswa'),

                        Infolists\Components\TextEntry::make('mahasiswa.nim')
                            ->label('NIM'),

                        Infolists\Components\TextEntry::make('mahasiswa.prodi.nama_prodi')
                            ->label('Program Studi'),

                        Infolists\Components\TextEntry::make('mahasiswa.ipk')
                            ->label('IPK Mahasiswa'),

                        Infolists\Components\TextEntry::make('mahasiswa.semester')
                            ->label('Semester Mahasiswa'),

                        Infolists\Components\TextEntry::make('tanggal_pengajuan')
                            ->label('Tanggal Pengajuan')
                            ->date('Y-m-d'),

                        Infolists\Components\TextEntry::make('status')
                            ->badge()
                            ->label('Status Pengajuan')
                            ->color(fn(string $state): string => match ($state) {
                                'Diajukan' => 'warning',
                                'Diterima' => 'success',
                                'Ditolak' => 'danger',
                                default => 'gray',
                            }),
                    ])->columns(2),

                Infolists\Components\Section::make('Informasi Lowongan')
                    ->schema([
                        Infolists\Components\TextEntry::make('lowongan.judul_lowongan')
                            ->label('Judul Lowongan'),

                        Infolists\Components\TextEntry::make('lowongan.perusahaan.nama')
                            ->label('Perusahaan'),

                        Infolists\Components\TextEntry::make('lowongan.bidangKeahlian.nama_bidang_keahlian')
                            ->label('Bidang Keahlian'),

                        Infolists\Components\TextEntry::make('lowongan.jenisMagang.nama_jenis_magang')
                            ->label('Jenis Magang'),

                        Infolists\Components\TextEntry::make('lowongan.daerahMagang.namaLengkapDenganProvinsi')
                            ->label('Daerah Magang'),

                        Infolists\Components\TextEntry::make('lowongan.periode.nama_periode')
                            ->label('Periode Magang'),

                        Infolists\Components\TextEntry::make('lowongan.waktuMagang.waktu_magang')
                            ->label('Waktu Magang'),

                        Infolists\Components\TextEntry::make('lowongan.batas_akhir_lamaran')
                            ->label('Batas Akhir Lamaran')
                            ->date('Y-m-d'),

                        Infolists\Components\TextEntry::make('lowongan.status')
                            ->badge()
                            ->label('Status Lowongan')
                            ->color(fn(string $state): string => match ($state) {
                                'Aktif' => 'success',
                                'Selesai' => 'danger',
                                default => 'gray',
                            }),
                    ])->columns(2),

            ]);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Status Pengajuan')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status Pengajuan')
                            ->default('Diajukan')
                            ->options([
                                'Diajukan' => 'Diajukan',
                                'Diterima' => 'Diterima',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_diterima')
                            ->label('Tanggal Diterima')
                            ->required(fn(Forms\Get $get) => $get('status') === 'Diterima'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.user.nama')
                    ->label('Nama Mahasiswa')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('lowongan.judul_lowongan')
                    ->label('Judul Lowongan')
                    ->limit(10)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->sortable()
                    ->date('Y-m-d'),

                Tables\Columns\TextColumn::make('tanggal_diterima')
                    ->label('Tanggal Diterima')
                    ->sortable()
                    ->date('Y-m-d'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->colors([
                        'warning' => 'Diajukan',
                        'success' => 'Diterima',
                        'danger' => 'Ditolak',
                    ])
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('tanggal_pengajuan', 'desc')
            ->emptyStateHeading('Belum ada kegiatan magang yang diajukan')
            ->emptyStateIcon('heroicon-o-document-text')
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
            'index' => Pages\ListKegiatanMagangs::route('/'),
            'create' => Pages\CreateKegiatanMagang::route('/create'),
            'view' => Pages\ViewKegiatanMagang::route('/{record}'),
            'edit' => Pages\EditKegiatanMagang::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['mahasiswa.user', 'mahasiswa.prodi', 'lowongan.perusahaan', 'lowongan.bidangKeahlian']);
    }
}
