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
use Filament\Forms\Components\Hidden; // ✅ DITAMBAHKAN

class PerusahaanResource extends Resource
{
    protected static ?string $model = PerusahaanModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-office';
    protected static ?string $navigationLabel = 'Perusahaan';
    protected static ?string $navigationGroup = 'Data Referensi';
    protected static ?string $slug = 'manajemen-perusahaan';
    protected static ?string $modelLabel = 'Perusahaan';
    protected static ?string $pluralModelLabel = 'Data Perusahaan';
    protected static ?int $navigationSort = 10;

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

                TextInput::make('website')
                    ->required(),

                Select::make('partnership')
                    ->label('Jenis Kemitraan')
                    ->options([
                        'Perusahaan Mitra' => 'Perusahaan Mitra',
                        'Perusahaan Non-Mitra' => 'Perusahaan Non-Mitra',
                    ])
                    ->default('Perusahaan Mitra')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->tooltip(fn($record) => $record->nama)
                    ->limit(20)
                    ->label('Nama Perusahaan'),
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->searchable()
                    ->sortable()
                    ->tooltip(fn($record) => $record->alamat)
                    ->limit(20),
                TextColumn::make('no_telepon')
                    ->label('No Telepon'),
                TextColumn::make('email')
                    ->label('Email')
                    ->limit(10)
                    ->tooltip(fn($record) => $record->email)
                    ->sortable(),
                TextColumn::make('website')
                    ->label('Website')
                    ->limit(15)
                    ->tooltip(fn($record) => $record->website)
                    ->url(fn($record) => $record->website ? (str_starts_with($record->website, 'http') ? $record->website : "https://{$record->website}") : null)
                    ->openUrlInNewTab(),
                TextColumn::make('partnership')
                    ->label('Jenis Kemitraan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Perusahaan Mitra' => 'success',
                        'Perusahaan Non-Mitra' => 'warning',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('partnership')
                    ->options([
                        'Perusahaan Mitra' => 'Perusahaan Mitra',
                        'Perusahaan Non-Mitra' => 'Perusahaan Non-Mitra',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'edit' => Pages\EditPerusahaan::route('/{record}/edit'),
        ];
    }
}
