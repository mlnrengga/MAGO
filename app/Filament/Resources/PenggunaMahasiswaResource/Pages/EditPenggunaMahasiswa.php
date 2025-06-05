<?php

namespace App\Filament\Resources\PenggunaMahasiswaResource\Pages;

use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PenggunaMahasiswaResource;

class EditPenggunaMahasiswa extends EditRecord
{
    protected static string $resource = PenggunaMahasiswaResource::class;

   protected function afterSave(): void
{
    $mahasiswa = $this->record->mahasiswa;

    if ($mahasiswa) {
        $mahasiswa->update([
            'nim' => $this->data['nim'],
            'id_prodi' => $this->data['id_prodi'],
        ]);
    }
}
}
