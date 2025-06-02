<?php

namespace App\Filament\Mahasiswa\Resources;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;
use App\Filament\Mahasiswa\Resources\ProfilMhsResource\RelationManagers;
use App\Models\Auth\MahasiswaModel;
use App\Models\ProfilMhs;
use App\Models\Reference\ProfilMhsModel;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProfilMhsResource extends Resource
{
    protected static ?string $model = ProfilMhsModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function getEloquentQuery(): Builder
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return static::getModel()::query()->whereRaw('1=0');
        }

        return static::getModel()::query()
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil')
                    ->schema([
                        FileUpload::make('user.profile_picture')
                            ->label('Foto Profil'),
                        TextInput::make('user.alamat'),
                        TextInput::make('user.no_telepon'),
                        TextInput::make('user.password')->password()->revealable(),
                    ]),

                Section::make('Pengalaman')
                    ->schema([
                        Textarea::make('pengalaman')
                            ->label('Deskripsi Pengalaman'),
                    ]),

                Section::make('Dokumen')
                    ->schema([
                        Repeater::make('dokumen')
                            ->label('')
                            ->relationship('dokumen')
                            ->schema([
                                TextInput::make('nama_dokumen'),
                                FileUpload::make('file_path'),
                            ])
                            ->deletable()
                            ->addActionLabel('Tambah Dokumen'),
                    ]),
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
            'index' => Pages\ListProfilMhs::route('/'),
            'create' => Pages\CreateProfilMhs::route('/create'),
            'edit' => Pages\EditProfil::route('/edit'),
            'view' => Pages\ViewProfilMhs::route('/{record}'),
            'edit-profil' => Pages\EditProfil::route('/{record}/edit-profil'),
            'edit-pengalaman' => Pages\EditPengalaman::route('/{record}/edit-pengalaman'),
            'edit-dokumen' => Pages\EditDokumen::route('/{record}/edit-dokumen'),
        ];
    }


    public static function getNavigationLabel(): string
    {
        return 'Profil Saya';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Profil Saya';
    }

    public static function getModelLabel(): string
    {
        return 'Profil Saya';
    }
}
