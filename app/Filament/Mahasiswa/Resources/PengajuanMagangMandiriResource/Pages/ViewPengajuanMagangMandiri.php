<?php

namespace App\Filament\Mahasiswa\Resources\PengajuanMagangMandiriResource\Pages;

use App\Filament\Mahasiswa\Resources\PengajuanMagangMandiriResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Grid;

class ViewPengajuanMagangMandiri extends ViewRecord
{
    protected static string $resource = PengajuanMagangMandiriResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Status Pengajuan')
                    ->schema([
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Diajukan' => 'warning',
                                'Diterima' => 'success',
                                'Ditolak' => 'danger',
                                default => 'gray',
                            }),

                        TextEntry::make('tanggal_pengajuan')
                            ->label('Tanggal Pengajuan')
                            ->date(),

                        TextEntry::make('tanggal_diterima')
                            ->label('Tanggal Diproses')
                            ->date()
                            ->visible(fn($record) => $record->status !== 'Diajukan'),
                    ])
                    ->columns(3),

                Section::make('Informasi Perusahaan')
                    ->schema([
                        TextEntry::make('lowongan.perusahaan.nama')
                            ->label('Nama Perusahaan'),

                        TextEntry::make('lowongan.perusahaan.alamat')
                            ->label('Alamat'),

                        TextEntry::make('lowongan.perusahaan.no_telepon')
                            ->label('Nomor Telepon')
                            ->icon('heroicon-m-phone'),

                        TextEntry::make('lowongan.perusahaan.email')
                            ->label('Email')
                            ->icon('heroicon-m-envelope'),

                        TextEntry::make('lowongan.perusahaan.website')
                            ->label('Website')
                            ->url(fn($state) => $state ? 'https://' . $state : null)
                            ->openUrlInNewTab()
                            ->visible(fn($record) => !empty($record->lowongan->perusahaan->website)),

                        TextEntry::make('lowongan.perusahaan.partnership')
                            ->label('Status Perusahaan')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Perusahaan Mitra' => 'success',
                                'Perusahaan Non-Mitra' => 'danger',
                                default => 'gray',
                            }),
                    ])
                    ->columns(2),

                Section::make('Informasi Magang')
                    ->schema([
                        TextEntry::make('lowongan.judul_lowongan')
                            ->label('Posisi/Jabatan Magang')
                            ->weight('bold'),

                        TextEntry::make('lowongan.jenisMagang.nama_jenis_magang')
                            ->label('Jenis Magang'),

                        TextEntry::make('lowongan.waktuMagang.waktu_magang')
                            ->label('Waktu Magang'),

                        TextEntry::make('lowongan.periode.nama_periode')
                            ->label('Periode'),

                        TextEntry::make('lowongan.insentif.keterangan')
                            ->label('Insentif'),

                        TextEntry::make('lowongan.batas_akhir_lamaran')
                            ->label('Tanggal Mulai')
                            ->date(),

                        TextEntry::make('lowongan.bidangKeahlian.nama_bidang_keahlian')
                            ->label('Bidang Keahlian')
                            ->listWithLineBreaks(),
                    ])
                    ->columns(2),

                Section::make('Lokasi')
                    ->schema([
                        TextEntry::make('lowongan.daerahMagang.provinsi.nama_provinsi')
                            ->label('Provinsi'),

                        TextEntry::make('lowongan.daerahMagang.namaLengkap')
                            ->label('Daerah (Kota/Kabupaten)'),
                    ])
                    ->columns(2),

                Section::make('Deskripsi')
                    ->schema([
                        TextEntry::make('lowongan.deskripsi_lowongan')
                            ->label('Deskripsi Magang')
                            ->html(),
                    ])
            ]);
    }
}
