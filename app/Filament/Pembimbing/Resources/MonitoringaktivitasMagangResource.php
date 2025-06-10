<?php

namespace App\Filament\Pembimbing\Resources;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;
use App\Models\Reference\LogMagangModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MonitoringaktivitasMagangResource extends Resource
{
    protected static ?string $model = LogMagangModel::class;

    protected static ?string $navigationLabel = 'Monitoring Magang';
    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    protected static ?string $modelLabel = 'Log Aktivitas';
    protected static ?string $pluralModelLabel = 'Monitoring Aktivitas';
    protected static ?string $navigationGroup = 'Monitoring & Mahasiswa';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $dosen = $user->dosenPembimbing;

        if (!$dosen) {
            return parent::getEloquentQuery()->whereRaw('1 = 0'); 
        }

        $penempatanIds = $dosen->mahasiswaBimbingan()
            ->pluck('t_penempatan_magang.id_penempatan')
            ->toArray();

        return parent::getEloquentQuery()
            ->whereIn('id_penempatan', $penempatanIds)
            ->with(['penempatan.mahasiswa.user']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('penempatan.mahasiswa.user.nama')
                ->label('Nama Mahasiswa')
                ->disabled()
                ->dehydrated(false),

            Forms\Components\DatePicker::make('tanggal_log')
                ->label('Tanggal Log')
                ->disabled()
                ->dehydrated(false),

            Forms\Components\Textarea::make('keterangan')
                ->label('Aktivitas Harian')
                ->disabled()
                ->dehydrated(false),

            Forms\Components\Textarea::make('feedback_progres')
                ->label('Feedback Dosen Pembimbing'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penempatan.mahasiswa.user.nama')->label('Mahasiswa'),
                Tables\Columns\TextColumn::make('tanggal_log')->label('Tanggal')->date(),
                Tables\Columns\TextColumn::make('keterangan')->label('Aktivitas')->limit(50),
                Tables\Columns\TextColumn::make('status')->label('Status Kehadiran'),
                Tables\Columns\TextColumn::make('feedback_progres')->label('Feedback')->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Beri Feedback'),
            ])
            ->headerActions([]) // Tidak bisa create log baru
            ->bulkActions([]);  // Tidak bisa hapus massal
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMonitoringaktivitasMagangs::route('/'),
            'edit' => Pages\EditMonitoringaktivitasMagang::route('/{record}/edit'),
        ];
    }
}
