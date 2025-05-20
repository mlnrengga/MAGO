<?php

namespace App\Filament\Mahasiswa\Resources\MahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\MahasiswaResource;
use Filament\Actions; // Perubahan di sini (dari `Filament\Pages\Actions`)
use Filament\Resources\Pages\CreateRecord;

class CreateMahasiswa extends CreateRecord
{
    protected static string $resource = MahasiswaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make() // Sekarang menggunakan `Filament\Actions`
                ->label('Tambahkan'),
        ];
    }
}