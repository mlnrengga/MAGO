<?php

namespace App\Filament\Pembimbing\Resources;

use App\Filament\Pembimbing\Resources\ManajemenMahasiswaBimbinganResource\Pages;
use App\Filament\Pembimbing\Resources\ManajemenMahasiswaBimbinganResource\RelationManagers;
use App\Models\Auth\DosenPembimbingModel;
use App\Models\Auth\MahasiswaModel;
use App\Models\ManajemenMahasiswaBimbingan;
use App\Models\Reference\BimbinganModel;
use App\Models\Reference\PenempatanMagangModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManajemenMahasiswaBimbinganResource extends Resource
{
    protected static ?string $model = PenempatanMagangModel::class;

    protected static ?string $navigationLabel = 'Mahasiswa Bimbingan';
    protected static ?string $pluralModelLabel = 'Data Mahasiswa Bimbingan';
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $idDospem = auth()->user()->dosenPembimbing->id_dospem;

        return PenempatanMagangModel::whereHas('dosenPembimbing', function ($query) use ($idDospem) {
            $query->where('r_bimbingan.id_dospem', $idDospem);
        })
            ->with(['mahasiswa.user']);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('mahasiswa.user.nama')
                    ->label('Nama Mahasiswa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mahasiswa.nim')
                    ->label('NIM')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mahasiswa.prodi.nama_prodi')
                    ->label('Program Studi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('mahasiswa.semester')
                    ->label('Semester')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status Magang')
                    ->badge()
                    ->color('success'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListManajemenMahasiswaBimbingans::route('/'),
            'view' => Pages\ViewMahasiswaBimbingan::route('/{record}'),
        ];
    }

}
