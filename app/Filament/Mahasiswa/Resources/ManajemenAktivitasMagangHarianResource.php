<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;
use App\Models\Reference\LogMagangModel;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ManajemenAktivitasMagangHarianResource extends Resource
{
    protected static ?string $model = LogMagangModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-check';
    protected static ?string $navigationLabel = 'Aktivitas Magang Harian';
    protected static ?string $slug = 'manajemen-aktivitas-magang-harian';
    protected static ?string $modelLabel = 'Aktivitas Magang';
    protected static ?string $pluralModelLabel = 'Data Aktivitas Magang Harian';
    protected static ?string $navigationGroup = 'Magang';

    public static function getEloquentQuery(): Builder
    {
        $idMahasiswa = Auth::user()->mahasiswa->id_mahasiswa ?? null;
        $penempatanId = request('penempatanId');

        $query = parent::getEloquentQuery()
            ->whereHas('penempatan.pengajuan', fn ($q) => $q->where('id_mahasiswa', $idMahasiswa))
            ->with(['penempatan.pengajuan', 'penempatan.pengajuan.mahasiswa']);

        if ($penempatanId) {
            $query->where('id_penempatan', $penempatanId);
        } else {
            // Jangan tampilkan data kalau belum pilih penempatan
            $query->whereRaw('1=0');
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('id_penempatan')
                    ->default(fn () => request('penempatanId')),

                DatePicker::make('tanggal_log')
                    ->label('Tanggal')
                    ->default(now())
                    ->required()
                    ->disabled(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'masuk' => 'Masuk',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'cuti' => 'Cuti',
                    ])
                    ->required(),
                    
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(7)
                    ->placeholder('Masukkan keterangan aktivitas magang')
                    ->helperText('Keterangan ini akan terlihat oleh pembimbing magang Anda.')
                    ->maxLength(300)
                    // ->columnSpanFull()
                    ->required(),

                Forms\Components\FileUpload::make('file_bukti')
                    ->label('File Bukti')
                    ->disk('cloudinary')
                    ->directory('bukti-magang')
                    ->visibility('public')
                    ->required()
                    ->image() // Bisa diganti dengan acceptedFileTypes jika perlu support PDF
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('2:1')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->maxSize(10 * 1024) // 10MB
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => 
                            'bukti-' . time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension()
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2, // 2 kolom di tablet
                'lg' => 3, // 3 kolom di desktop
                'xl' => 3, // 3 kolom di layar besar
            ])
            ->recordClasses(function ($record) {
                return 'bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden';
            })
            // ->extraAttributes(['class' => 'gap-4 p-4'])
            ->columns([
                // Tables\Columns\TextColumn::make('penempatan.pengajuan.mahasiswa.user.name')
                //     ->label('Nama Mahasiswa'),
                // Tables\Columns\TextColumn::make('tanggal_log')
                //     ->label('Tanggal')
                //     ->date('d M Y')
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('status')
                //     ->label('Status')
                //     ->badge()
                //     ->color(fn (string $state): string => match ($state) {
                //         'masuk' => 'success',
                //         'izin' => 'warning',
                //         'sakit' => 'danger',
                //         'cuti' => 'info',
                //     }),
                // Tables\Columns\TextColumn::make('keterangan')
                //     ->label('Keterangan')
                //     ->limit(50),
                // // Tables\Columns\TextColumn::make('file_bukti')
                // //     ->label('File Bukti')
                // //     ->formatStateUsing(fn ($state) => $state ? 'Ada' : 'Tidak Ada'),
                // Tables\Columns\ImageColumn::make('file_bukti')
                //     ->label('File Bukti')
                //     ->disk('cloudinary'),
                // Tables\Columns\TextColumn::make('feedback_progres')
                //     ->label('Feedback')
                //     ->limit(30),
                // Tables\Columns\TextColumn::make('penempatan.pengajuan.lowongan.perusahaan.nama_perusahaan')
                //     ->label('Perusahaan')
                //     ->sortable(),
                
                Tables\Columns\Layout\Stack::make([
                    // Gambar di bagian atas card
                    Tables\Columns\ImageColumn::make('file_bukti')
                        ->disk('cloudinary')
                        ->height(200)
                        ->extraImgAttributes(['class' => 'w-full h-[200px] object-cover']),
                    
                    // Konten di bawah gambar
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\Layout\Grid::make([
                            'default' => 2,
                            'md' => 2
                        ])->schema([
                            Tables\Columns\TextColumn::make('tanggal_log')
                                ->date('d M Y')
                                ->weight('bold')
                                ->size('lg'),
                                
                            Tables\Columns\TextColumn::make('status')
                                ->badge()
                                ->alignRight()
                                ->color(fn (string $state): string => match ($state) {
                                    'masuk' => 'success',
                                    'izin' => 'warning',
                                    'sakit' => 'danger',
                                    'cuti' => 'info',
                                }),
                        ]),
                        
                        // Keterangan
                        Tables\Columns\TextColumn::make('keterangan')
                            ->limit(100)
                            ->wrap(),
                            
                        // Footer info
                        Tables\Columns\Layout\Grid::make([
                            'default' => 2,
                            'md' => 2
                        ])->schema([
                            Tables\Columns\TextColumn::make('penempatan.pengajuan.mahasiswa.user.name')
                                ->color('gray')
                                ->size('sm'),
                                
                            Tables\Columns\TextColumn::make('feedback_progres')
                                ->formatStateUsing(fn ($state) => $state ? 'Ada feedback' : 'Belum ada feedback')
                                ->icon(fn ($state) => $state ? 'heroicon-m-chat-bubble-left-ellipsis' : null)
                                ->iconPosition('after')
                                ->alignRight()
                                ->color('gray')
                                ->size('sm'),
                        ]),
                    ])->space(3),
                ]),

                // // Gunakan struktur yang lebih sederhana dulu untuk debugging
                // Tables\Columns\Layout\Stack::make([
                //     // Header
                //     Tables\Columns\Layout\Grid::make([
                //         'default' => 2
                //     ])->schema([
                //         Tables\Columns\TextColumn::make('id_log')
                //             ->label('ID')
                //             ->weight('bold'),
                            
                //         Tables\Columns\TextColumn::make('status')
                //             ->badge()
                //             ->color(fn (string $state): string => match ($state) {
                //                 'masuk' => 'success',
                //                 'izin' => 'warning',
                //                 'sakit' => 'danger',
                //                 'cuti' => 'info',
                //             })
                //             ->alignRight(),
                //     ]),
                    
                //     // Gambar tanpa height constraint agar mudah muncul
                //     Tables\Columns\ImageColumn::make('file_bukti')
                //         ->disk('cloudinary'),
                    
                //     // Keterangan
                //     Tables\Columns\TextColumn::make('keterangan')
                //         ->limit(100),
                        
                //     // Tanggal
                //     Tables\Columns\TextColumn::make('tanggal_log')
                //         ->date('d M Y'),
                // ])->space(2)->padding(4),
            ])
            // ->columns([
            //     Tables\Columns\TextColumn::make('id_log')
            //         ->label('ID'),
                
            //     Tables\Columns\TextColumn::make('tanggal_log')
            //         ->label('Tanggal')
            //         ->date('d M Y'),
                    
            //     Tables\Columns\TextColumn::make('status')
            //         ->label('Status')
            //         ->badge()
            //         ->color(fn (string $state): string => match ($state) {
            //             'masuk' => 'success',
            //             'izin' => 'warning',
            //             'sakit' => 'danger',
            //             'cuti' => 'info',
            //         }),
                    
            //     Tables\Columns\TextColumn::make('keterangan')
            //         ->label('Keterangan')
            //         ->limit(50),
                    
            //     Tables\Columns\ImageColumn::make('file_bukti')
            //         ->label('File Bukti')
            //         ->disk('cloudinary'),
            // ])
            ->filters([
                //
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->button()
                    ->modalContent(fn (LogMagangModel $record): string => view('filament.mahasiswa.resources.log-magang.view', ['record' => $record])->render()),
                Tables\Actions\EditAction::make()
                    ->button(),
                Tables\Actions\DeleteAction::make()
                    ->button(),
            ], position: ActionsPosition::AfterContent)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Tidak ada data aktivitas magang yang ditemukan')
            ->emptyStateDescription('Silakan buat aktivitas magang baru.')
            ->paginated([10, 25, 50, 'all']);
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
            'index' => Pages\ListManajemenAktivitasMagangHarians::route('/'),
            'create' => Pages\CreateManajemenAktivitasMagangHarian::route('/create'),
            // 'edit' => Pages\EditManajemenAktivitasMagangHarian::route('/{record}/edit'),
        ];
    }
}

// namespace App\Filament\Mahasiswa\Resources;

// use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;
// use App\Models\Reference\LogMagangModel;
// use Filament\Forms;
// use Filament\Forms\Form;
// use Filament\Resources\Resource;
// use Filament\Tables;
// use Filament\Tables\Columns\Layout\Stack;
// use Filament\Tables\Table;
// use Illuminate\Database\Eloquent\Builder;

// class ManajemenAktivitasMagangHarianResource extends Resource
// {
//     protected static ?string $model = LogMagangModel::class;
//     protected static ?string $navigationIcon = 'heroicon-s-clipboard-document-check';
//     protected static ?string $navigationLabel = 'Aktivitas Magang Harian';
//     protected static ?string $slug = 'manajemen-aktivitas-magang-harian';
//     protected static ?string $modelLabel = 'Aktivitas Magang';
//     protected static ?string $pluralModelLabel = 'Data Aktivitas Magang Harian';
//     protected static ?string $navigationGroup = 'Magang';

//     // Gunakan ini kalau memang perlu filter khusus
//     public static function getEloquentQuery(): Builder
//     {
//         $query = parent::getEloquentQuery();
//         $penempatanId = request('penempatanId');
//         if ($penempatanId) {
//             $query->where('id_penempatan', $penempatanId);
//         }
//         return $query;
//     }

//     public static function form(Form $form): Form
//     {
//         return $form->schema([
//             // Hidden field untuk id_penempatan (kalau pakai filter penempatan)
//             Forms\Components\Hidden::make('id_penempatan'),

//             Forms\Components\DatePicker::make('tanggal_log')
//                 ->label('Tanggal')
//                 ->default(now())
//                 ->required(),

//             Forms\Components\Select::make('status')
//                 ->label('Status')
//                 ->options([
//                     'masuk' => 'Masuk',
//                     'izin' => 'Izin',
//                     'sakit' => 'Sakit',
//                     'cuti' => 'Cuti',
//                 ])
//                 ->required(),

//             Forms\Components\Textarea::make('keterangan')
//                 ->label('Keterangan')
//                 ->rows(7)
//                 ->placeholder('Masukkan keterangan aktivitas magang')
//                 ->helperText('Keterangan ini akan terlihat oleh pembimbing magang Anda.')
//                 ->maxLength(300)
//                 ->required(),

//             Forms\Components\FileUpload::make('file_bukti')
//                 ->label('File Bukti')
//                 ->disk('cloudinary')
//                 ->directory('bukti-magang')
//                 ->visibility('public')
//                 ->required()
//                 ->image()
//                 ->imagePreviewHeight('250')
//                 ->maxSize(10 * 1024),
//         ]);
//     }

//     public static function table(Table $table): Table
//     {
//         return $table
//             ->contentGrid([
//                 'md' => 2,
//                 'lg' => 3,
//             ])
//             ->recordClasses('bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden')
//             ->columns([
//                 Tables\Columns\Layout\Stack::make([
//                     Tables\Columns\ImageColumn::make('file_bukti')
//                         ->disk('cloudinary')
//                         ->height(200)
//                         ->extraImgAttributes(['class' => 'w-full h-[200px] object-cover']),

//                     Tables\Columns\Layout\Stack::make([
//                         Tables\Columns\Layout\Grid::make(['default' => 2])->schema([
//                             Tables\Columns\TextColumn::make('tanggal_log')
//                                 ->date('d M Y')
//                                 ->weight('bold')
//                                 ->size('lg'),
//                             Tables\Columns\TextColumn::make('status')
//                                 ->badge()
//                                 ->alignRight()
//                                 ->color(fn (string $state): string => match ($state) {
//                                     'masuk' => 'success',
//                                     'izin' => 'warning',
//                                     'sakit' => 'danger',
//                                     'cuti' => 'info',
//                                     default => 'gray',
//                                 }),
//                         ]),
//                         Tables\Columns\TextColumn::make('keterangan')
//                             ->limit(100)
//                             ->wrap(),
//                         Tables\Columns\Layout\Grid::make(['default' => 2])->schema([
//                             Tables\Columns\TextColumn::make('penempatan.pengajuan.mahasiswa.user.name')
//                                 ->color('gray')
//                                 ->size('sm')
//                                 ->default('-'),
//                             Tables\Columns\TextColumn::make('feedback_progres')
//                                 ->formatStateUsing(fn ($state) => $state ? 'Ada feedback' : 'Belum ada feedback')
//                                 ->icon(fn ($state) => $state ? 'heroicon-m-chat-bubble-left-ellipsis' : null)
//                                 ->iconPosition('after')
//                                 ->alignRight()
//                                 ->color('gray')
//                                 ->size('sm')
//                                 ->default('-'),
//                         ]),
//                     ]),
//                 ]),
//             ])
//             ->actions([
//                 Tables\Actions\ViewAction::make()
//                     ->button(),
//                 Tables\Actions\EditAction::make()
//                     ->button(),
//                 Tables\Actions\DeleteAction::make()
//                     ->button(),
//             ], position: Tables\Enums\ActionsPosition::AfterContent);
//     }
    
//     public static function getPages(): array
//     {
//         return [
//             'index' => Pages\ListManajemenAktivitasMagangHarians::route('/'),
//             'create' => Pages\CreateManajemenAktivitasMagangHarian::route('/create'), // AKTIFKAN INI
//             'edit' => Pages\EditManajemenAktivitasMagangHarian::route('/{record}/edit'),
//         ];
//     }
// }