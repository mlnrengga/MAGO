<?php

namespace App\Filament\Resources\PenggunaMahasiswaResource\Pages;

namespace App\Filament\Resources\PenggunaMahasiswaResource\Pages;

use App\Models\Auth\MahasiswaModel;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PenggunaMahasiswaResource;

class CreatePenggunaMahasiswa extends CreateRecord
{
    protected static string $resource = PenggunaMahasiswaResource::class;
protected function afterCreate(): void
{
    MahasiswaModel::create([
        'id_user'   => $this->record->id_user,
        'nim'       => $this->data['nim'],
        'id_prodi'  => $this->data['id_prodi'],
        'ipk'       => $this->data['ipk'],       // Ambil dari input admin
        'semester'  => $this->data['semester'],  // Ambil dari input admin
    ]);
}

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
