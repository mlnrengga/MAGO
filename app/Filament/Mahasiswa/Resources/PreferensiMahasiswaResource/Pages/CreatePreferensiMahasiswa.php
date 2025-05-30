<?php

namespace App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\PreferensiMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePreferensiMahasiswa extends CreateRecord
{
    protected static string $resource = PreferensiMahasiswaResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_mahasiswa'] = Auth::user()->mahasiswa->id_mahasiswa;
        return $data;
    }

    
}
