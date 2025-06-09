<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\UserModel;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PenggunaMahasiswaResource\Pages;
use App\Filament\Resources\PenggunaMahasiswaResource\Pages\CreatePenggunaMahasiswa;
use Illuminate\Database\Eloquent\Model;

class PenggunaMahasiswaResource extends Resource
{
    protected static ?string $model = UserModel::class;

    protected static ?string $navigationLabel = 'Manajemen Mahasiswa';
    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?string $modelLabel = 'Manajemen - Mahasiswa';
    protected static ?string $pluralModelLabel = 'Data Mahasiswa';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?int $navigationSort = 4;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('id_role', 2)
            ->with('mahasiswa');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Mahasiswa')->schema([
                Forms\Components\Hidden::make('id_role')->default(2),

                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required(),

                Forms\Components\TextInput::make('alamat')
                    ->required()
                    ->label('Alamat'),

                Forms\Components\TextInput::make('no_telepon')
                    ->label('No Telepon')
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->revealable()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreatePenggunaMahasiswa)
                    ->dehydrated(fn($state) => filled($state)),

                Forms\Components\TextInput::make('password_confirmation')
                    ->label('Konfirmasi Password')
                    ->password()
                    ->revealable()
                    ->required(fn($livewire) => $livewire instanceof CreatePenggunaMahasiswa)
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

                Forms\Components\TextInput::make('nim')
                    ->label('NIM')
                    ->required()
                    ->afterStateHydrated(function ($component) {
                        $mahasiswa = optional($component->getRecord()?->mahasiswa);
                        $component->state($mahasiswa->nim);
                    })
                    ->dehydrated(false),

                Forms\Components\Select::make('id_prodi')
                    ->label('Program Studi')
                    ->options(\App\Models\Reference\ProdiModel::pluck('nama_prodi', 'id_prodi'))
                    ->required()
                    ->afterStateHydrated(function ($component) {
                        $component->state(optional($component->getRecord()?->mahasiswa)->id_prodi);
                    })
                    ->dehydrated(false),


                Forms\Components\TextInput::make('ipk')
                    ->required()
                    ->label('IPK')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(4)
                    ->step(0.01)
                    ->afterStateHydrated(fn($component) =>
                    $component->state(optional($component->getRecord()?->mahasiswa)->ipk))
                    ->dehydrated(false),

                Forms\Components\TextInput::make('semester')
                    ->label('Semester')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(14)
                    ->afterStateHydrated(fn($component) =>
                    $component->state(optional($component->getRecord()?->mahasiswa)->semester))
                    ->dehydrated(false),



            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Lengkap')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('mahasiswa.nim')
                ->label('NIM')
                ->sortable()
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
        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make()
                ->before(function (Model $record) {
                    if ($record->mahasiswa) {
                        $record->mahasiswa->delete();
                    }
                }),
        ])->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ])->emptyStateHeading('Belum ada data mahasiswa')
            ->emptyStateIcon('heroicon-s-academic-cap');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenggunaMahasiswas::route('/'),
            'create' => Pages\CreatePenggunaMahasiswa::route('/create'),
            'edit' => Pages\EditPenggunaMahasiswa::route('/{record}/edit'),
        ];
    }
}
