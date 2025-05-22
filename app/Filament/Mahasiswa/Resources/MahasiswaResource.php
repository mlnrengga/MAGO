<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\MahasiswaResource\Pages;
use App\Models\Auth\MahasiswaModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Illuminate\Database\Eloquent\Builder;

class MahasiswaResource extends Resource
{
    protected static ?string $model = MahasiswaModel::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $modelLabel = 'Profil Mahasiswa';
    protected static ?string $pluralModelLabel = 'Profil Saya';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nim')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->length(15)
                    ->numeric()
                    ->placeholder('Masukkan NIM tanpa spasi'),

                Forms\Components\TextInput::make('program_studi')
                    ->required()
                    ->placeholder('Contoh: Teknik Informatika'),

                Forms\Components\Textarea::make('riwayat_kesehatan')
                    ->placeholder('Masukkan riwayat kesehatan (jika ada)')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(static::getTableQuery())
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('program_studi')
                    ->label('Program Studi')
                    ->searchable()
                    ->sortable(),
            ])
            ->actions([
                EditAction::make()
                    ->label('Edit Profil')
                    ->visible(fn($record) => $record->user_id === auth()->id()),
            ])
            ->bulkActions([])
            ->emptyStateActions([]);
    }

    protected static function getTableQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id_user', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMahasiswa::route('/'),
            'edit' => Pages\EditMahasiswa::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->role === 'mahasiswa';
    }
}