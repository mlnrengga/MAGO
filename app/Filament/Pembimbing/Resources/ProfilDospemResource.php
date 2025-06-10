<?php

namespace App\Filament\Pembimbing\Resources;

use App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;
use App\Filament\Pembimbing\Resources\ProfilDospemResource\RelationManagers;
use App\Models\Auth\DosenPembimbingModel;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ProfilDospemResource extends Resource
{
    protected static ?string $model = DosenPembimbingModel::class;

    protected static ?string $navigationIcon = 'heroicon-s-user';
    protected static ?string $navigationLabel = 'Profil';
    protected static ?string $pluralModelLabel = 'Profil Saya';
    protected static ?string $navigationGroup = 'Tentang Saya';
    protected static ?int $navigationSort = 3;

    public static function getNavigationUrl(): string
    {
        $user = Auth::user();
        if ($user && $user->dosenPembimbing) {
            return static::getUrl('view', ['record' => $user->dosenPembimbing->id_dospem]);
        }
        return static::getUrl('dashboard');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dosen Pembimbing')
                    ->description('Perbarui detail pribadi dan kontak Anda.')
                    ->schema([
                        TextInput::make('user.nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nip')
                            ->label('NIP')
                            ->maxLength(20)
                            ->readOnly()
                            ->helperText('NIP tidak dapat diubah.'),
                        TextInput::make('user.no_telepon')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        TextInput::make('user.alamat')
                            ->label('Alamat')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('user.profile_picture')
                            ->label('Foto Profil Saat Ini')
                            ->previewable(true)
                            ->image()
                            // ->imagePreviewHeight('150')
                            ->disk('public')
                            ->directory('foto-profil')
                            ->visibility('public')
                            ->panelLayout('integrated')
                            ->openable()
                            ->downloadable()
                            ->helperText('Kosongkan jika tidak ingin mengubah foto')
                            ->nullable(),
                    ])->columns(2),

                Section::make('Bidang Keahlian')
                    ->description('Pilih bidang keahlian yang relevan.')
                    ->schema([
                        Select::make('bidangKeahlian')
                            ->label('Bidang Keahlian')
                            ->multiple()
                            ->relationship('bidangKeahlian', 'nama_bidang_keahlian')
                            ->preload()
                            ->searchable()
                            ->helperText('Pilih satu atau lebih bidang keahlian Anda.'),
                    ]),

                Section::make('Ganti Password (Opsional)')
                    ->description('Isi kolom ini hanya jika Anda ingin mengubah password Anda.')
                    ->schema([
                        TextInput::make('user.password')
                            ->label('Password Baru')
                            ->password()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->confirmed()
                            ->autocomplete('new-password')
                            ->helperText('Biarkan kosong jika tidak ingin mengubah password.'),
                        TextInput::make('user.password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->maxLength(255)
                            ->dehydrated(false)
                            ->required(fn(string $operation): bool => $operation === 'create' && filled(request()->input('data.user.password'))), // Required jika password diisi saat create
                    ])->columns(2),
            ]);
    }


    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([

    //         ])
    //         ->filters([

    //         ])
    //         ->actions([

    //         ])
    //         ->bulkActions([

    //         ]);
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfilDospem::route('/'),
            'view' => Pages\ViewProfilDospem::route('/{record}'),
            'edit' => Pages\EditProfilDospem::route('/{record}/edit'),
        ];
    }
}
