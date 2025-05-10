<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\MahasiswaResource\Pages;
use App\Filament\Mahasiswa\Resources\MahasiswaResource\RelationManagers;
use App\Models\Auth\MahasiswaModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MahasiswaResource extends Resource
{
    protected static ?string $model = MahasiswaModel::class;


    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $pluralModelLabel = 'Profil';
    
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('nim')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\TextInput::make('program_studi')
                ->required(),
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->required(),
            Forms\Components\Textarea::make('riwayat_kesehatan'),
            Forms\Components\Select::make('bidang_keahlian_id')
                ->relationship('bidangKeahlian', 'nama_bidang')
                ->required(),
            Forms\Components\Select::make('lokasi_preferensi_id')
                ->relationship('lokasiPreferensi', 'nama_lokasi')
                ->required(),
            Forms\Components\Select::make('jenis_magang_preferensi_id')
                ->relationship('jenisMagangPreferensi', 'nama_jenis')
                ->required(),
            Forms\Components\Select::make('dosen_pembimbing_id')
                ->relationship('dosen', 'nip')
                ->label('Dosen Pembimbing')
                ->searchable(),
            Forms\Components\Select::make('status_pengajuan_magang')
                ->options([
                    'belum' => 'Belum',
                    'diajukan' => 'Diajukan',
                    'diterima' => 'Diterima',
                    'ditolak' => 'Ditolak'
                ])
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label('Nama'),
                Tables\Columns\TextColumn::make('nim')->searchable(),
                Tables\Columns\TextColumn::make('program_studi'),
                Tables\Columns\TextColumn::make('bidangKeahlian.nama_bidang')->label('Bidang'),
                Tables\Columns\TextColumn::make('status_pengajuan_magang')->label('Status'),
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
            'index' => Pages\ListMahasiswas::route('/'),
            'create' => Pages\CreateMahasiswa::route('/create'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'mahasiswa';
    }
    
    
}
