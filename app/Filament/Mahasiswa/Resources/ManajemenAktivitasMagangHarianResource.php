<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;
use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\RelationManagers;
use App\Models\ManajemenAktivitasMagangHarian;
use App\Models\Reference\LogMagangModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

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
                Forms\Components\Textarea::make('keterangan')
                ->label('Keterangan')
                ->required(),

                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'masuk' => 'Masuk',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                        'cuti' => 'Cuti',
                    ])
                    ->required(),

                Forms\Components\FileUpload::make('file_bukti')
                    ->label('File Bukti')
                    ->directory('bukti-log-magang')
                    ->required()
                    ->preserveFilenames()
                    ->maxSize(5 * 1024) // 5 MB
                    ->acceptedFileTypes(['application/pdf', 'image/*']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penempatan.pengajuan.mahasiswa.user.name')
                    ->label('Nama Mahasiswa'),
                Tables\Columns\TextColumn::make('tanggal_log')
                    ->label('Tanggal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')->limit(50),
                Tables\Columns\TextColumn::make('file_bukti')
                    ->label('File Bukti')
                    ->formatStateUsing(fn ($state) => $state ? 'Ada' : 'Tidak Ada'),
                Tables\Columns\TextColumn::make('feedback_progres')
                    ->label('Feedback')
                    ->limit(30),
                Tables\Columns\TextColumn::make('penempatan.pengajuan.lowongan.perusahaan.nama_perusahaan')
                    ->label('Perusahaan')
                    ->sortable(),
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
            ])
            ->emptyStateHeading('Tidak ada data aktivitas magang yang ditemukan')
            ->emptyStateDescription('Silakan buat aktivitas magang baru.');
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
            'edit' => Pages\EditManajemenAktivitasMagangHarian::route('/{record}/edit'),
        ];
    }
}
