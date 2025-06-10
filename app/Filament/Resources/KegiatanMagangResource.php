<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanMagangResource\Pages;
use App\Filament\Resources\KegiatanMagangResource\RelationManagers;
use App\Models\KegiatanMagang;
use App\Models\Reference\PengajuanMagangModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class KegiatanMagangResource extends Resource
{
    protected static ?string $model = PengajuanMagangModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-check';
    protected static ?string $navigationLabel = 'Pengajuan & Lamaran Magang';
    protected static ?string $slug = 'kegiatan-magang';
    protected static ?string $modelLabel = 'Pengajuan Magang';
    protected static ?string $pluralModelLabel = 'Data Pengajuan & Lamaran Magang';
    protected static ?string $navigationGroup = 'Administrasi Magang';
    protected static ?int $navigationSort = 1;

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

                        Infolists\Components\Section::make('Preferensi Mahasiswa')
                            ->schema([
                                Infolists\Components\TextEntry::make('mahasiswa.preferensi.daerahMagang.namaLengkapDenganProvinsi')
                                    ->label('Daerah Magang')
                                    ->default('Semua')
                                    ->placeholder('Semua'),

                                Infolists\Components\TextEntry::make('jenisMagang')
                                    ->label('Jenis Magang')
                                    ->default('Semua')
                                    ->placeholder('Semua')
                                    ->getStateUsing(function ($record) {
                                        try {
                                            if (!$record->mahasiswa->preferensi) {
                                                return 'Semua';
                                            }

                                            $preferensi = $record->mahasiswa->preferensi;

                                            $jenisMagangs = DB::table('m_jenis_magang')
                                                ->join('r_preferensi_jenis_magang', 'm_jenis_magang.id_jenis_magang', '=', 'r_preferensi_jenis_magang.id_jenis_magang')
                                                ->where('r_preferensi_jenis_magang.id_preferensi', $preferensi->id_preferensi)
                                                ->pluck('m_jenis_magang.nama_jenis_magang')
                                                ->toArray();

                                            if (empty($jenisMagangs)) {
                                                return 'Semua';
                                            }

                                            return implode(', ', $jenisMagangs);
                                        } catch (\Exception $e) {
                                            return 'Semua: ' . $e->getMessage();
                                        }
                                    }),

                                Infolists\Components\TextEntry::make('bidangMahasiswa')
                                    ->label('Bidang Keahlian')
                                    ->default('Semua')
                                    ->placeholder('Semua')
                                    ->getStateUsing(function ($record) {
                                        try {
                                            if (!$record->mahasiswa->preferensi) {
                                                return 'Semua';
                                            }

                                            $preferensi = $record->mahasiswa->preferensi;
                                            $bidangKeahlians = DB::table('m_bidang_keahlian')
                                                ->join('r_preferensi_bidang', 'm_bidang_keahlian.id_bidang', '=', 'r_preferensi_bidang.id_bidang')
                                                ->where('r_preferensi_bidang.id_preferensi', $preferensi->id_preferensi)
                                                ->pluck('m_bidang_keahlian.nama_bidang_keahlian')
                                                ->toArray();

                                            if (empty($bidangKeahlians)) {
                                                return 'Semua';
                                            }

                                            return implode(', ', $bidangKeahlians);
                                        } catch (\Exception $e) {
                                            return 'Semua: ' . $e->getMessage();
                                        }
                                    }),

                                Infolists\Components\TextEntry::make('mahasiswa.preferensi.insentif.keterangan')
                                    ->label('Insentif')
                                    ->default('Semua')
                                    ->placeholder('Semua'),

                                Infolists\Components\TextEntry::make('mahasiswa.preferensi.waktuMagang.waktu_magang')
                                    ->label('Waktu Magang')
                                    ->default('Semua')
                                    ->placeholder('Semua'),

                            ])->columns(2)
                            ->collapsible(),

                        Infolists\Components\Section::make('Dokumen Mahasiswa')
                            ->schema([
                                Infolists\Components\RepeatableEntry::make('mahasiswa.dokumen')
                                    ->schema([
                                        Infolists\Components\TextEntry::make('jenis_dokumen')
                                            ->label('Jenis Dokumen'),

                                        Infolists\Components\TextEntry::make('path_dokumen')
                                            ->label('Lihat Dokumen')
                                            ->color('primary')
                                            ->formatStateUsing(function ($state, $record) {
                                                $extension = pathinfo($state, PATHINFO_EXTENSION);
                                                return $record->nama_dokumen . '.' . $extension;
                                            })
                                            ->url(fn($record) => asset('storage/' . $record->path_dokumen), true)
                                            ->openUrlInNewTab(),
                                    ])
                                    ->columns(2),

                                Infolists\Components\TextEntry::make('dokumenEmpty')
                                    ->label('')
                                    ->default('Mahasiswa belum mengunggah dokumen apapun')
                                    ->visible(function ($record) {
                                        return !$record->mahasiswa->dokumen || $record->mahasiswa->dokumen->isEmpty();
                                    }),
                            ])
                            // ->columns(2)
                            ->collapsible(),
                    ])->columns(3),

                Infolists\Components\Section::make('Informasi Perusahaan')
                    ->schema([
                        Infolists\Components\TextEntry::make('lowongan.perusahaan.nama')
                            ->label('Perusahaan'),

                        Infolists\Components\TextEntry::make('lowongan.perusahaan.no_telepon')
                            ->label('Nomor Telepon Perusahaan')
                            ->icon('heroicon-m-phone'),

                        Infolists\Components\TextEntry::make('lowongan.perusahaan.website')
                            ->label('Website Perusahaan')
                            ->icon('heroicon-m-globe-alt'),

                        Infolists\Components\TextEntry::make('lowongan.perusahaan.partnership')
                            ->label('Status Perusahaan')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Perusahaan Mitra' => 'success',
                                'Perusahaan Non-Mitra' => 'danger',
                                default => 'gray',
                            }),

                        Infolists\Components\TextEntry::make('lowongan.perusahaan.alamat')
                            ->label('Alamat Perusahaan')
                            ->columnSpanFull(),
                    ])->columns(2),

                Infolists\Components\Section::make('Detail Magang')
                    ->schema([
                        Infolists\Components\TextEntry::make('lowongan.judul_lowongan')
                            ->label('Judul Lowongan'),

                        Infolists\Components\TextEntry::make('lowongan.jenisMagang.nama_jenis_magang')
                            ->label('Jenis Magang'),

                        Infolists\Components\TextEntry::make('lowongan.daerahMagang.provinsi.nama_provinsi')
                            ->label('Provinsi'),

                        Infolists\Components\TextEntry::make('lowongan.daerahMagang.namaLengkap')
                            ->label('Daerah (Kota/Kabupaten)'),

                        Infolists\Components\TextEntry::make('lowongan.periode.nama_periode')
                            ->label('Periode'),

                        Infolists\Components\TextEntry::make('lowongan.waktuMagang.waktu_magang')
                            ->label('Waktu Magang'),

                        Infolists\Components\TextEntry::make('lowongan.insentif.keterangan')
                            ->label('Insentif'),


                        Infolists\Components\TextEntry::make('lowongan.status')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Aktif' => 'success',
                                'Selesai' => 'danger',
                                default => 'gray',
                            }),
                        Infolists\Components\TextEntry::make('lowongan.tanggal_posting')
                            ->label('Tanggal Posting')
                            ->date(),

                        Infolists\Components\TextEntry::make('lowongan.batas_akhir_lamaran')
                            ->label('Batas Akhir Lamaran')
                            ->date(),

                        Infolists\Components\TextEntry::make('lowongan.deskripsi_lowongan')
                            ->label('Deskripsi Lowongan')
                            ->html()
                            ->columnSpanFull(),
                    ])->columns(3),
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
                            ->live()
                            ->afterStateUpdated(function (string $state, callable $set) {
                                if ($state === 'Diterima') {
                                    $set('tanggal_diterima', now()->format('Y-m-d'));
                                }
                            })
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_diterima')
                            ->label('Tanggal Diterima')
                            ->default(now()->format('Y-m-d'))
                            ->displayFormat('Y-m-d')
                            ->visible(fn(Forms\Get $get) => $get('status') === 'Diterima')
                            ->disabled() // Make it read-only
                            ->dehydrated(fn(Forms\Get $get) => $get('status') === 'Diterima'),
                    ])->columns(2),

                Forms\Components\Section::make('Dosen Pembimbing')
                    ->schema([
                        Forms\Components\Select::make('dosen_pembimbing')
                            ->label('Dosen Pembimbing')
                            ->options(function () {
                                $dosenOptions = [];
                                $dosenList = \App\Models\Auth\DosenPembimbingModel::query()
                                    ->with('bidangKeahlian', 'user')
                                    ->get();

                                foreach ($dosenList as $dosen) {
                                    $bidangKeahlian = $dosen->bidangKeahlian->pluck('nama_bidang_keahlian')->toArray();
                                    $bidangText = !empty($bidangKeahlian)
                                        ? implode(', ', $bidangKeahlian)
                                        : 'Tidak Ada';

                                    $dosenOptions[$dosen->id_dospem] = $dosen->user->nama . ' (' . $bidangText . ')';
                                }

                                return $dosenOptions;
                            })
                            ->searchable()
                            ->required(fn(Forms\Get $get) => $get('status') === 'Diterima')
                            ->visible(fn(Forms\Get $get) => $get('status') === 'Diterima'),
                    ])
                    ->visible(fn(Forms\Get $get) => $get('status') === 'Diterima'),

                Forms\Components\Section::make('Catatan Penolakan')
                    ->schema([
                        Forms\Components\RichEditor::make('alasan_penolakan')
                            ->required(fn(Forms\Get $get) => $get('status') === 'Ditolak')
                            ->visible(fn(Forms\Get $get) => $get('status') === 'Ditolak'),
                    ])
                    ->visible(fn(Forms\Get $get) => $get('status') === 'Ditolak'),
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
                    ->limit(20)
                    ->copyable()
                    ->tooltip(fn($record) => $record->lowongan->judul_lowongan)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('lowongan.jenisMagang.nama_jenis_magang')
                    ->label('Jenis Magang')
                    ->limit(15)
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->sortable()
                    ->date(),

                Tables\Columns\TextColumn::make('tanggal_diterima')
                    ->label('Tanggal Diterima')
                    ->sortable()
                    ->date(),

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
                Tables\Filters\SelectFilter::make('jenis_magang')
                    ->label('Jenis Magang')
                    ->relationship('lowongan.jenisMagang', 'nama_jenis_magang')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'Diajukan' => 'Diajukan',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('perusahaan')
                    ->label('Perusahaan')
                    ->relationship('lowongan.perusahaan', 'nama')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading('Hapus Pengajuan Magang')
                    ->modalDescription('Apakah Anda yakin ingin menghapus pengajuan magang ini?')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal')
                    ->hidden(function (PengajuanMagangModel $record) {
                        return $record->status === 'Diterima';
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->modalHeading('Hapus Pengajuan Magang')
                        ->modalDescription('Apakah Anda yakin ingin menghapus pengajuan magang ini? Pengajuan dengan status Diterima tidak akan dihapus.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->deselectRecordsAfterCompletion()
                        ->before(function ($records) {
                            $cannotDeleteRecords = [];

                            foreach ($records as $key => $record) {
                                if ($record->status === 'Diterima') {
                                    $cannotDeleteRecords[] = $record->mahasiswa->user->nama ?? ('Pengajuan #' . $record->id_pengajuan);
                                    $records->forget($records->search($record));
                                }
                            }

                            if (count($cannotDeleteRecords) > 0) {
                                Notification::make()
                                    ->warning()
                                    ->title('Perhatian')
                                    ->body('Beberapa pengajuan magang dengan status Diterima tidak dapat dihapus: ' . implode(', ', $cannotDeleteRecords))
                                    ->send();
                            }

                            if ($records->isEmpty()) {
                                Notification::make()
                                    ->danger()
                                    ->title('Gagal')
                                    ->body('Semua pengajuan yang dipilih memiliki status Diterima dan tidak dapat dihapus.')
                                    ->send();
                                return false;
                            }
                        }),
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
            ->with(['mahasiswa.user', 'mahasiswa.prodi', 'lowongan.perusahaan', 'lowongan.bidangKeahlian', 'mahasiswa.dokumen']);
    }
}
