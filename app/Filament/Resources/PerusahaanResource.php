<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Perusahaan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Models\Reference\PerusahaanModel;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PerusahaanResource\Pages;
use App\Filament\Resources\PerusahaanResource\RelationManagers;

class PerusahaanResource extends Resource
{
    protected static ?string $model = PerusahaanModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-office';
    protected static ?string $navigationLabel = 'Perusahaan Mitra';
    protected static ?string $navigationGroup = 'Pengguna & Mitra';
    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'manajemen-perusahaan';
    protected static ?string $modelLabel = 'Perusahaan';
    protected static ?string $pluralModelLabel = 'Data Perusahaan Mitra';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),

                TextInput::make('alamat')
                    ->required()
                    ->maxLength(255),

                TextInput::make('no_telepon')
                    ->label('No Telepon')
                    ->tel()
                    ->required(),

                TextInput::make('email')
                    ->email()
                    ->required(),
      Forms\Components\Hidden::make('id_admin')
    ->default(fn () => auth()->user() ? auth()->user()->id : 1) // fallback ke id 1 misal
    ->dehydrated(true)
    ->required(),

            // ✅ hanya untuk tampilan
            TextInput::make('nama_admin')
                ->label('Admin Penanggung Jawab')
                ->default(fn () => auth()->user()->nama)
                ->disabled()
                ->dehydrated(false),

                TextInput::make('website')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->searchable()->label('Nama Perusahaan'),
                TextColumn::make('alamat')->limit(50),
                TextColumn::make('no_telepon')->label('No Telepon'),
                TextColumn::make('email'),
                TextColumn::make('admin.user.nama')->label('Nama Admin'),
                TextColumn::make('website')->label('Website'),
            ])
            ->filters([
                // Tambahkan filter jika dibutuhkan
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // View pakai bawaan
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record, $action) {
                        if ($record->lowonganMagang()->exists()) {
                            $action->failure('Perusahaan tidak bisa dihapus karena masih memiliki lowongan magang.');
                            $action->halt();
                        }
                    }),
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
            // Tambahkan RelationManager jika perlu
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerusahaans::route('/'),
            'create' => Pages\CreatePerusahaan::route('/create'),
            'view' => Pages\ViewPerusahaan::route('/{record}'), // Aktifkan halaman view
            'edit' => Pages\EditPerusahaan::route('/{record}/edit'),
        ];
    }
}
