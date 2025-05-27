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

class KegiatanMagangResource extends Resource
{
    protected static ?string $model = PengajuanMagangModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'Manajemen Kegiatan Magang';
    protected static ?string $slug = 'kegiatan-magang';
    protected static ?string $modelLabel = 'Pengajuan Magang';
    protected static ?string $pluralModelLabel = 'Data Pengajuan Magang';
    protected static ?string $navigationGroup = 'Magang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
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
                
                Tables\Columns\BadgeColumn::make('status')
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
                Tables\Actions\EditAction::make(),
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
            'edit' => Pages\EditKegiatanMagang::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
