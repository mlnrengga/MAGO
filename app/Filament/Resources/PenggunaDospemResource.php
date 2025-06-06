<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggunaDospemResource\Pages\CreatePenggunaDospem;
use App\Filament\Resources\PenggunaDospemResource\Pages\EditPenggunaDospem;
use App\Filament\Resources\PenggunaDospemResource\Pages\ListPenggunaDospems;
use App\Models\Auth\DosenPembimbingModel;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\UserModel;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class PenggunaDospemResource extends Resource
{
    protected static ?string $model = UserModel::class;

    protected static ?string $navigationLabel = 'Dosen Pembimbing';
    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?string $modelLabel = 'Manajemen - Dosen';
    protected static ?string $pluralModelLabel = 'Data Dosen Pembimbing';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id_role', 3);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Dosen')
                ->schema([
                    Forms\Components\Hidden::make('id_role')->default(3),

                    Forms\Components\TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->required(),

                    Forms\Components\TextInput::make('nip')
                        ->label('NIP')
                        ->afterStateHydrated(function ($component) {
                            $dospem = optional($component->getRecord()?->dosenPembimbing);
                            $component->state($dospem->nip ?? '');
                        })
                        ->required(),

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
                        ->required(fn($livewire) => $livewire instanceof CreatePenggunaDospem)
                        ->dehydrated(fn($state) => filled($state))
                        ->rule('min:8'),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Konfirmasi Password')
                        ->password()
                        ->revealable()
                        ->required(fn($livewire) => $livewire instanceof CreatePenggunaDospem)
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
                Tables\Columns\TextColumn::make('nama')->label('Nama Lengkap')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('dosenPembimbing.nip')->label('NIP')->sortable(),
                Tables\Columns\TextColumn::make('no_telepon')->label('No Telepon')->sortable(),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat')->sortable(),
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
                        if ($record->dosenPembimbing) {
                            $record->dosenPembimbing->delete();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('Belum ada data dosen pembimbing')
            ->emptyStateIcon('heroicon-s-user-circle');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenggunaDospems::route('/'),
            'create' => CreatePenggunaDospem::route('/create'),
            'edit' => EditPenggunaDospem::route('/{record}/edit'),
        ];
    }
}
