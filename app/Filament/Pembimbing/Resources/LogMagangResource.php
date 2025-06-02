<?php

namespace App\Filament\Pembimbing\Resources;

use App\Models\Reference\LogMagangModel;
use App\Filament\Pembimbing\Resources\LogMagangResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Table;

class LogMagangResource extends Resource
{
    protected static ?string $model = LogMagangModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Monitoring Magang';
    protected static ?string $slug = 'monitoring-magang';
    protected static ?string $navigationGroup = 'Monitoring & Evaluasi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Log Aktivitas')
                ->schema([
                    Forms\Components\DatePicker::make('tanggal_log')
                        ->label('Tanggal')
                        ->disabled(),

                    Forms\Components\Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->disabled(),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'Masuk' => 'Masuk',
                            'Izin' => 'Izin',
                            'Sakit' => 'Sakit',
                            'Cuti' => 'Cuti',
                        ])
                        ->disabled(),

                    Forms\Components\FileUpload::make('file_bukti')
                        ->label('Bukti Log')
                        ->directory('log-bukti')
                        ->downloadable()
                        ->disabled(),

                    Forms\Components\Textarea::make('feedback_progres')
                        ->label('Feedback Dosen Pembimbing')
                        ->rows(4)
                        ->maxLength(1000)
                        ->required(),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('penempatan.mahasiswa.user.nama')
                    ->label('Mahasiswa')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_log')
                    ->label('Tanggal')
                    ->date(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status'),

                Tables\Columns\TextColumn::make('feedback_progres')
                    ->label('Feedback')
                    ->limit(40),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Beri Feedback'),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogMagangs::route('/'),
            'edit' => Pages\EditLogMagang::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role?->kode_role === 'DSP'; // Sesuaikan kode role dosen pembimbing
    }
}


