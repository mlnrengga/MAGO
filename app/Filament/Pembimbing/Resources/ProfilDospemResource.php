<?php

namespace App\Filament\Pembimbing\Resources;

use App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;
use App\Filament\Pembimbing\Resources\ProfilDospemResource\RelationManagers;
use App\Models\Auth\DosenPembimbingModel;
use App\Models\ProfilDospem;
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

class ProfilDospemResource extends Resource
{
    protected static ?string $model = DosenPembimbingModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dosen Pembimbing')
                    ->description('Perbarui detail pribadi dan kontak Anda.')
                    ->schema([
                        TextInput::make('user.nama') // Mengambil dari relasi user
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('nip') // NIP biasanya tidak diubah
                            ->label('NIP')
                            ->maxLength(20)
                            ->readOnly() // Membuat field ini hanya bisa dibaca
                            ->helperText('NIP tidak dapat diubah.'),
                        TextInput::make('user.no_telepon') // Mengambil dari relasi user
                            ->label('Nomor Telepon')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        TextInput::make('user.alamat') // Mengambil dari relasi user
                            ->label('Alamat')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('user.profile_picture') // Mengambil dari relasi user
                            ->label('Foto Profil')
                            ->image()
                            ->directory('profile-pictures') // Folder penyimpanan di storage
                            ->nullable(),
                    ])->columns(2),

                Section::make('Bidang Keahlian')
                    ->description('Pilih bidang keahlian yang relevan.')
                    ->schema([
                        Select::make('bidangKeahlian') // Mengambil dari relasi many-to-many
                            ->label('Bidang Keahlian')
                            ->multiple() // Memungkinkan pemilihan banyak bidang
                            ->relationship('bidangKeahlian', 'nama_bidang_keahlian')
                            ->preload() // Memuat semua opsi di awal untuk UX yang lebih baik
                            ->searchable() // Memungkinkan pencarian bidang keahlian
                            ->helperText('Pilih satu atau lebih bidang keahlian Anda.'),
                    ]),

                Section::make('Ganti Password (Opsional)')
                    ->description('Isi kolom ini hanya jika Anda ingin mengubah password Anda.')
                    ->schema([
                        TextInput::make('user.password')
                            ->label('Password Baru')
                            ->password()
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)) // Hash password sebelum disimpan
                            ->dehydrated(fn (?string $state): bool => filled($state)) // Hanya dehidrasi jika field diisi
                            ->required(fn (string $operation): bool => $operation === 'create') // Password hanya wajib saat membuat user baru
                            ->confirmed() // Membutuhkan field konfirmasi
                            ->autocomplete('new-password')
                            ->helperText('Biarkan kosong jika tidak ingin mengubah password.'),
                        TextInput::make('user.password_confirmation')
                            ->label('Konfirmasi Password Baru')
                            ->password()
                            ->maxLength(255)
                            ->dehydrated(false) // Jangan simpan ke database, hanya untuk validasi
                            ->required(fn (string $operation): bool => $operation === 'create' && filled(request()->input('data.user.password'))), // Required jika password diisi saat create
                    ])->columns(2),
            ]); 

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListProfilDospems::route('/'),
            'create' => Pages\CreateProfilDospem::route('/create'),
            'edit' => Pages\EditProfilDospem::route('/{record}/edit'),
        ];
    }
}
