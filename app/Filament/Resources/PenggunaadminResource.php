<?php

namespace App\Filament\Resources;

use App\Models\UserModel;
use App\Filament\Resources\PenggunaadminResource\Pages; // ✅ perbaikan namespace
use App\Filament\Resources\PenggunaadminResource\Pages\CreatePenggunaadmin;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PenggunaadminResource extends Resource
{
    protected static ?string $model = UserModel::class;
    protected static ?string $navigationLabel = 'Manajemen Admin';
    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?string $modelLabel = 'Manajemen - Admin';
    protected static ?string $pluralModelLabel = 'Data Admin';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('id_role', 1)->with('admin');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Admin')
                ->schema([
                    Forms\Components\Hidden::make('id_role')->default(1),

                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required(),

                    Forms\Components\TextInput::make('nip')
                        ->label('NIP')
                        ->required(fn($livewire) => $livewire instanceof Pages\CreatePenggunaadmin)
                        ->afterStateHydrated(function ($component) {
                            $admin = optional($component->getRecord()?->admin); // aman
                            $component->state($admin->nip);
                        })
                        ->dehydrated(false),

                    Forms\Components\TextInput::make('alamat')
                        ->label('Alamat')
                        ->required(),

                    Forms\Components\TextInput::make('no_telepon')
                        ->label('No Telepon')
                        ->required(),

                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->required(fn($livewire) => $livewire instanceof Pages\CreatePenggunaadmin) // ✅ perbaikan instance check
                        ->dehydrated(fn($state) => filled($state)),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->revealable()
                        ->required(fn($livewire) => $livewire instanceof CreatePenggunaadmin)
                        ->dehydrated(false)
                        ->rule('min:8')
                        ->same('password'),

                    Forms\Components\FileUpload::make('profile_picture')
                        ->label('Foto Profil')
                        ->image()
                        ->directory('foto-profil')
                        ->disk('public')
                        ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif'])
                        ->maxSize(2048),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('admin.nip')
                    ->label('NIP')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('no_telepon')
                    ->label('No Telepon')
                    ->sortable(),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->sortable(),

                Tables\Columns\ImageColumn::make('profile_picture')
                    ->label('Foto Profil')
                    ->defaultImageUrl(asset('assets/images/default.png'))
                    ->circular(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Model $record) {
                        if ($record->admin) {
                            $record->admin->delete();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('Belum ada data admin')
            ->emptyStateIcon('heroicon-s-user-group');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenggunaadmins::route('/'),
            'create' => Pages\CreatePenggunaadmin::route('/create'),
            'edit' => Pages\EditPenggunaadmin::route('/{record}/edit'),
        ];
    }
}
