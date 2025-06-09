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

    protected static ?string $navigationIcon = 'heroicon-s-user';
    protected static ?string $navigationLabel = 'Profil';
    protected static ?string $pluralModelLabel = 'Profil Saya';
    protected static ?string $navigationGroup = 'Tentang Saya';
    protected static ?int $navigationSort = 7;

    public static function getEloquentQuery(): Builder
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if (!$mahasiswa) {
            return static::getModel()::query()->whereRaw('1=0');
        }

        return static::getModel()::query()
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa);
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
}
