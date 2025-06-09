<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource\Pages;
use App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource\RelationManagers;
use App\Models\EvaluasiHasilMagang;
use App\Models\Reference\HasilMagangModel;
use App\Models\Reference\PenempatanMagangModel;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EvaluasiHasilMagangResource extends Resource
{
    protected static ?string $model = HasilMagangModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-document-check';
    protected static ?string $navigationLabel = 'Evaluasi Hasil Magang';
    protected static ?string $slug = 'evaluasi-hasil-magang';
    protected static ?string $modelLabel = 'Evaluasi Hasil Magang';
    protected static ?string $pluralModelLabel = 'Data Evaluasi Hasil Magang';
    protected static ?string $navigationGroup = 'Aktivitas & Evaluasi';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section Informasi Lowongan
                Forms\Components\Section::make('Informasi Magang')
                    ->description('Detail lowongan magang yang sedang dievaluasi')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('lowongan')
                                            ->label('Lowongan Magang')
                                            ->content(function (Get $get, $record) {
                                                if ($record && $record->penempatanMagang) {
                                                    return $record->penempatanMagang->pengajuan->lowongan->judul_lowongan;
                                                }
                                                
                                                return 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-briefcase'),
                                    ]),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('perusahaan')
                                            ->label('Perusahaan')
                                            ->content(function ($record, $livewire) {
                                                if ($record && $record->penempatanMagang) {
                                                    return $record->penempatanMagang->pengajuan->lowongan->perusahaan->nama;
                                                } else if (isset($livewire->penempatan)) {
                                                    return $livewire->penempatan->pengajuan->lowongan->perusahaan->nama;
                                                }
                                                
                                                return 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-building-office'),
                                    ]),
                                    
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('alamat_perusahaan')
                                            ->label('Alamat Perusahaan Pusat')
                                            ->content(function ($record, $livewire) {
                                                if ($record && $record->penempatanMagang) {
                                                    return $record->penempatanMagang->pengajuan->lowongan->perusahaan->alamat;
                                                } else if (isset($livewire->penempatan)) {
                                                    return $livewire->penempatan->pengajuan->lowongan->perusahaan->alamat;
                                                }
                                                
                                                return 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-map-pin'),
                                    ]),
                                    
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('lokasi_magang')
                                            ->label('Lokasi Tempat Magang')
                                            ->content(function ($record, $livewire) {
                                                if ($record && $record->penempatanMagang) {
                                                    if (method_exists($record->penempatanMagang->pengajuan->lowongan->daerahMagang, 'namaLengkapDenganProvinsi')) {
                                                        return $record->penempatanMagang->pengajuan->lowongan->daerahMagang->namaLengkapDenganProvinsi;
                                                    }
                                                } else if (isset($livewire->penempatan)) {
                                                    if (method_exists($livewire->penempatan->pengajuan->lowongan->daerahMagang, 'namaLengkapDenganProvinsi')) {
                                                        return $livewire->penempatan->pengajuan->lowongan->daerahMagang->namaLengkapDenganProvinsi;
                                                    }
                                                }
                                                
                                                return 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-map'),
                                    ]),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('jenis_magang')
                                            ->label('Jenis Magang')
                                            ->content(function ($record, $livewire) {
                                                if ($record && $record->penempatanMagang) {
                                                    return $record->penempatanMagang->pengajuan->lowongan->jenisMagang->nama_jenis_magang;
                                                } else if (isset($livewire->penempatan)) {
                                                    return $livewire->penempatan->pengajuan->lowongan->jenisMagang->nama_jenis_magang;
                                                }
                                                
                                                return 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-tag'),
                                    ]),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('bidang_keahlian')
                                            ->label('Bidang Keahlian')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } else if (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }

                                                if (!$penempatan) {
                                                    return 'N/A';
                                                }
                                                
                                                $bidangKeahlian = $penempatan->pengajuan->lowongan->bidangKeahlian;
                                                
                                                if ($bidangKeahlian->isEmpty()) {
                                                    return 'N/A';
                                                }
                                                
                                                return $bidangKeahlian->pluck('nama_bidang_keahlian')->implode(', ');
                                            })
                                            ->hintIcon('heroicon-o-academic-cap'),
                                    ]),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('durasi')
                                            ->label('Durasi Magang')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } else if (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }
                                                
                                                if (!$penempatan) {
                                                    return 'N/A';
                                                }

                                                $waktuMagang = $penempatan->pengajuan->lowongan->waktuMagang->waktu_magang;
                                                
                                                return $waktuMagang;
                                            })
                                            ->hintIcon('heroicon-o-clock'),
                                    ]),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('tgl_mulai')
                                            ->label('Tanggal Mulai Magang')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } else if (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }
                                                
                                                if (!$penempatan) {
                                                    return 'N/A';
                                                }
                                                
                                                $tanggalDiterima = Carbon::parse($penempatan->pengajuan->tanggal_diterima);
                                                return $tanggalDiterima->format('d M Y');
                                            })
                                            ->hintIcon('heroicon-o-calendar'),
                                    ]),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('tgl_selesai')
                                            ->label('Tanggal Selesai Magang')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } else if (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }
                                                
                                                if (!$penempatan) {
                                                    return 'N/A';
                                                }
                                                
                                                $tanggalDiterima = Carbon::parse($penempatan->pengajuan->tanggal_diterima);
                                                $waktuMagang = $penempatan->pengajuan->lowongan->waktuMagang->waktu_magang;
                                                
                                                // Mengekstrak angka dari waktu magang
                                                preg_match('/(\d+)/', $waktuMagang, $matches);
                                                $bulan = isset($matches[1]) ? (int)$matches[1] : 0;
                                                
                                                $tanggalSelesai = $tanggalDiterima->copy()->addMonths($bulan);
                                                return $tanggalSelesai->format('d M Y');
                                            })
                                            ->hintIcon('heroicon-o-calendar'),
                                    ]),
                            ])
                            ->columns(2)
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg',
                    ]),
                
                // Section Informasi Dosen Pembimbing
                Forms\Components\Section::make('Informasi Dosen Pembimbing')
                    ->description('Detail dosen pembimbing untuk magang ini')
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('nama_dosen')
                                            ->label('Nama Dosen Pembimbing')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } elseif (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }
                                                
                                                if (!$penempatan || !$penempatan->dosenPembimbing()->exists()) {
                                                    return 'Belum ditentukan';
                                                }
                                                
                                                return $penempatan->dosenPembimbing()->first()->user->nama ?? 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-user'),
                                    ]),
                                    
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('nip_dosen')
                                            ->label('NIP Dosen')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } elseif (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }
                                                
                                                if (!$penempatan || !$penempatan->dosenPembimbing()->exists()) {
                                                    return 'Belum ditentukan';
                                                }
                                                
                                                return $penempatan->dosenPembimbing()->first()->nip ?? 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-identification'),
                                    ]),
                                    
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('telepon_dosen')
                                            ->label('Nomor Telepon Dosen')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } elseif (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }
                                                
                                                if (!$penempatan || !$penempatan->dosenPembimbing()->exists()) {
                                                    return 'Belum ditentukan';
                                                }
                                                
                                                return $penempatan->dosenPembimbing()->first()->user->no_telepon ?? 'N/A';
                                            })
                                            ->hintIcon('heroicon-o-phone'),
                                    ]),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Placeholder::make('bidang_keahlian_dosen')
                                            ->label('Bidang Keahlian Dosen')
                                            ->content(function ($record, $livewire) {
                                                $penempatan = null;
                                                
                                                if ($record && $record->penempatanMagang) {
                                                    $penempatan = $record->penempatanMagang;
                                                } elseif (isset($livewire->penempatan)) {
                                                    $penempatan = $livewire->penempatan;
                                                }
                                                
                                                if (!$penempatan || !$penempatan->dosenPembimbing()->exists()) {
                                                    return 'Belum ditentukan';
                                                }
                                                
                                                $dosen = $penempatan->dosenPembimbing()->first();
                                                $bidangKeahlian = $dosen->bidangKeahlian;
                                                
                                                if ($bidangKeahlian->isEmpty()) {
                                                    return 'Tidak ada bidang keahlian terdaftar';
                                                }
                                                
                                                return $bidangKeahlian->pluck('nama_bidang_keahlian')->implode(', ');
                                            })
                                            ->hintIcon('heroicon-o-academic-cap'),
                                    ]),
                            ])
                            ->columns(2)
                    ])
                    ->collapsible()
                    ->collapsed(false)
                    ->extraAttributes([
                        'class' => 'bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg',
                    ]),
                
                    // hidden field untuk menyimpan id_penempatan
                Forms\Components\Hidden::make('id_penempatan')
                    ->required(),
                
                // FORM untuk evaluasi hasil magang
                Forms\Components\Section::make('Evaluasi Hasil Magang')
                    ->description('Masukkan evaluasi hasil magang Anda')
                    ->schema([
                        Forms\Components\TextInput::make('nama_dokumen')
                            ->label('Nama Dokumen')
                            ->required()
                            ->placeholder('Contoh: Sertifikat Magang PT ABC, atau Surat Keterangan Magang PT XYZ')
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->hint('Masukkan nama dokumen yang relevan dengan hasil magang Anda.'),
                            
                        Forms\Components\Select::make('jenis_dokumen')
                            ->label('Jenis Dokumen')
                            ->required()
                            ->options([
                                'Sertifikat' => 'Sertifikat',
                                'Surat Keterangan Magang' => 'Surat Keterangan Magang',
                            ]),
                            
                        Forms\Components\DatePicker::make('tanggal_upload')
                            ->label('Tanggal Upload')
                            ->required()
                            ->default(now())
                            ->maxDate(now())
                            ->displayFormat('d M Y')
                            ->native(false)
                            ->disabled()
                            ->dehydrated(),
                            
                        Forms\Components\FileUpload::make('path_dokumen')
                            ->label('Upload Dokumen')
                            ->directory('dokumen-hasil-magang')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->required()
                            ->preserveFilenames()
                            ->hint('Hanya file PDF yang diperbolehkan. Ukuran maksimal 10 MB.'),
                            
                        Forms\Components\Textarea::make('feedback_magang')
                            ->label('Feedback Magang')
                            ->required()
                            ->placeholder('Berikan feedback atau kesan pesan selama melaksanakan magang')
                            ->rows(5)
                            ->columnSpanFull()
                            ->hint('Berikan feedback atau kesan pesan selama melaksanakan magang Anda.'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                return PenempatanMagangModel::query()
                    ->where('id_mahasiswa', auth()->user()->mahasiswa->id_mahasiswa)
                    ->with([
                        'pengajuan.lowongan.perusahaan', 
                        'pengajuan.lowongan.jenisMagang',
                        'pengajuan.lowongan.waktuMagang',
                        'hasilMagang'
                    ]);
            })
            ->columns([
                Tables\Columns\TextColumn::make('pengajuan.lowongan.judul_lowongan')
                    ->label('Nama Lowongan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->extraHeaderAttributes(['style' => 'width: 220px; min-width: 220px;'])
                    ->extraCellAttributes(['style' => 'width: 220px; min-width: 220px;'])
                    ->limit(30) 
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        return $column->getState(); // Tampilkan teks lengkap saat hover
                    }),
                    
                Tables\Columns\TextColumn::make('pengajuan.lowongan.perusahaan.nama')
                    ->label('Perusahaan')
                    ->searchable()
                    ->sortable()
                    ->extraHeaderAttributes(['style' => 'width: 180px; min-width: 180px;'])
                    ->extraCellAttributes(['style' => 'width: 180px; min-width: 180px;'])
                    ->limit(25)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        return $column->getState();
                    }),
                    
                Tables\Columns\TextColumn::make('pengajuan.lowongan.jenisMagang.nama_jenis_magang')
                    ->label('Jenis Magang')
                    ->searchable()
                    ->sortable()
                    ->extraHeaderAttributes(['style' => 'width: 150px; min-width: 150px;'])
                    ->extraCellAttributes(['style' => 'width: 150px; min-width: 150px;'])
                    ->limit(20)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        return $column->getState();
                    }),
                    
                Tables\Columns\TextColumn::make('magang_berakhir')
                    ->label('Magang Berakhir Pada')
                    ->extraHeaderAttributes(['style' => 'width: 150px; min-width: 150px;'])
                    ->extraCellAttributes(['style' => 'width: 150px; min-width: 150px;'])
                    ->getStateUsing(function ($record): string {
                        // mengambil tanggal diterima dan waktu magang
                        $tanggalDiterima = Carbon::parse($record->pengajuan->tanggal_diterima);
                        $waktuMagang = $record->pengajuan->lowongan->waktuMagang->waktu_magang;

                        // mengambil angka dari string waktu magang (contoh: "6 bulan")
                        preg_match('/(\d+)/', $waktuMagang, $matches);
                        $bulan = isset($matches[1]) ? (int)$matches[1] : 0;
                        
                        // menambahkan bulan ke tanggal diterima
                        $tanggalBerakhir = $tanggalDiterima->copy()->addMonths($bulan);
                        
                        return $tanggalBerakhir->format('d M Y');
                    })
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('sisa_durasi')
                    ->label('Sisa Durasi Magang')
                    ->extraHeaderAttributes(['style' => 'width: 160px; min-width: 160px;'])
                    ->extraCellAttributes(['style' => 'width: 160px; min-width: 160px;'])
                    ->getStateUsing(function ($record): string {
                        // mengambil tanggal diterima dan waktu magang
                        $tanggalDiterima = Carbon::parse($record->pengajuan->tanggal_diterima);
                        $waktuMagang = $record->pengajuan->lowongan->waktuMagang->waktu_magang;
                        
                        // mengambil angka dari string waktu magang (contoh: "6 bulan")
                        preg_match('/(\d+)/', $waktuMagang, $matches);
                        $bulan = isset($matches[1]) ? (int)$matches[1] : 0;
                        
                        // menambahkan bulan ke tanggal diterima
                        $tanggalBerakhir = $tanggalDiterima->copy()->addMonths($bulan);
                        
                        // menghitung selisih dengan hari ini
                        $sekarang = Carbon::now();
                        
                        if ($sekarang > $tanggalBerakhir) {
                            return 'Magang telah selesai';
                        }
                        
                        $selisih = $sekarang->diff($tanggalBerakhir);
                        
                        return $selisih->format('%m bulan %d hari lagi');
                    }),
                    
                Tables\Columns\TextColumn::make('status_evaluasi')
                    ->badge()
                    ->label('Evaluasi')
                    ->extraHeaderAttributes(['style' => 'width: 120px; min-width: 120px;'])
                    ->extraCellAttributes(['style' => 'width: 120px; min-width: 120px;'])
                    ->alignCenter()
                    ->getStateUsing(function ($record): string {
                        // Cek apakah sudah ada data hasil magang
                        return $record->hasilMagang()->exists() ? 'Sudah Dievaluasi' : 'Belum Evaluasi';
                    })
                    ->colors([
                        'success' => 'Sudah Dievaluasi',
                        'danger' => 'Belum Evaluasi',
                    ])
                    ->tooltip(function ($record): string {
                        // mengambil tanggal diterima dan waktu magang untuk menentukan tanggal selesai
                        $tanggalDiterima = Carbon::parse($record->pengajuan->tanggal_diterima);
                        $waktuMagang = $record->pengajuan->lowongan->waktuMagang->waktu_magang;
                        
                        // mengambil angka bulan dari string waktu magang
                        preg_match('/(\d+)/', $waktuMagang, $matches);
                        $bulan = isset($matches[1]) ? (int)$matches[1] : 0;

                        // menghitung tanggal berakhir magang
                        $tanggalBerakhir = $tanggalDiterima->copy()->addMonths($bulan);
                        $sekarang = Carbon::now();
                        
                        // sudah dievaluasi
                        if ($record->hasilMagang()->exists()) {
                            $tanggalEvaluasi = Carbon::parse($record->hasilMagang->created_at)->format('d M Y');
                            return "Evaluasi telah dilakukan pada {$tanggalEvaluasi}. Anda dapat melihat detail evaluasi dengan mengklik tombol 'View'.";
                        } 
                        // belum evaluasi
                        else {
                            // belum saatnya evaluasi (magang belum selesai)
                            if ($sekarang < $tanggalBerakhir) {
                                $selisih = $sekarang->diff($tanggalBerakhir);
                                return "Magang Anda masih berlangsung. Evaluasi dapat dilakukan setelah magang selesai dalam {$selisih->format('%m bulan %d hari')} lagi.";
                            } 
                            // sudah saatnya evaluasi (magang sudah selesai)
                            else {
                                $selisih = $tanggalBerakhir->diff($sekarang);
                                return "Magang Anda telah selesai sejak {$selisih->format('%m bulan %d hari')} yang lalu. Silakan segera lakukan evaluasi.";
                            }
                        }
                    }),
            ])
            ->striped() 
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('tambahEvaluasi')
                    ->label(fn ($record) => $record->hasilMagang()->exists() ? 'Ubah Evaluasi' : 'Tambahkan Evaluasi')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->color(fn ($record) => $record->hasilMagang()->exists() ? 'warning' : 'success')
                    ->url(fn ($record) => $record->hasilMagang()->exists() 
                        ? static::getUrl('edit', ['record' => $record->hasilMagang->id_hasil_magang])
                        : static::getUrl('create', ['id_penempatan' => $record->id_penempatan])
                    ),
                    // ->visible(fn ($record) => 
                    //     Carbon::now() >= Carbon::parse($record->pengajuan->tanggal_diterima)->addMonths(
                    //         preg_match('/(\d+)/', $record->pengajuan->lowongan->waktuMagang->waktu_magang, $matches) ? (int)$matches[1] : 0
                    //     )
                    // ),
                    // ->disabled(fn ($record) => 
                    //     Carbon::now() < Carbon::parse($record->pengajuan->tanggal_diterima)->addMonths(
                    //         preg_match('/(\d+)/', $record->pengajuan->lowongan->waktuMagang->waktu_magang, $matches) ? (int)$matches[1] : 0
                    //     )
                    // ),
                
                Tables\Actions\ViewAction::make()
                    ->url(fn ($record) => $record->hasilMagang()->exists()
                        ? route('filament.mahasiswa.resources.evaluasi-hasil-magang.view', ['record' => $record->hasilMagang->id_hasil_magang])
                        : null
                    )
                    ->visible(fn ($record) => $record->hasilMagang()->exists()),
            ])
            ->recordUrl(null)
            ->bulkActions([])
            ->emptyStateHeading('Tidak ada data evaluasi yang ditemukan')
            ->emptyStateDescription('Anda belum memiliki magang yang perlu dievaluasi.')
            ->paginated([10, 25, 50, 'all'])
            ->defaultPaginationPageOption(10);
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
            'index' => Pages\ListEvaluasiHasilMagangs::route('/'),
            'create' => Pages\CreateEvaluasiHasilMagang::route('/create/{id_penempatan?}'),
            'edit' => Pages\EditEvaluasiHasilMagang::route('/{record}/edit'),
            'view' => Pages\ViewEvaluasiHasilMagang::route('/{record}/view'),
        ];
    }
}
