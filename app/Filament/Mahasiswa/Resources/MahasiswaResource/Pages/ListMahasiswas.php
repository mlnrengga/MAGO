<?php

namespace App\Filament\Mahasiswa\Resources\MahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\MahasiswaResource;
use Filament\Resources\Pages\ListRecords;

class ListMahasiswa extends ListRecords
{
    protected static string $resource = MahasiswaResource::class;

    // Hapus tombol "Tambah Profil Mahasiswa"
    protected function getHeaderActions(): array
    {
        return [];
    }
}
