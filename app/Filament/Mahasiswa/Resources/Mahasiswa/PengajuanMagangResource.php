<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Models\PengajuanMagang;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PengajuanMagangResource extends Resource
{
    protected static ?string $model = PengajuanMagang::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Pengajuan Magang';
    protected static ?string $modelLabel = 'Pengajuan Magang';

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('lowongan.judul_lowongan')
                    ->label('Judul Lowongan')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'diajukan' => 'Sedang Diajukan',
                        'diterima' => 'Diterima',
                        'ditolak' => 'Ditolak',
                        default => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'diterima' => 'success',
                        'ditolak' => 'danger',
                        'diajukan' => 'warning',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('tanggal_pengajuan')
                    ->label('Tanggal Pengajuan')
                    ->date(),
            ])
            ->filters([])
            ->actions([])
            ->bulkActions([]);
    }

    protected static function getTableQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id_mahasiswa', auth()->user()->mahasiswa->id);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPengajuanMagang::route('/'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'mahasiswa';
    }
}