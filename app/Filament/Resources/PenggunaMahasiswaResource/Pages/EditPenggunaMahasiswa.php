<?php

namespace App\Filament\Resources\PenggunaMahasiswaResource\Pages;

use App\Models\Auth\MahasiswaModel;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PenggunaMahasiswaResource;

class EditPenggunaMahasiswa extends EditRecord
{
    protected static string $resource = PenggunaMahasiswaResource::class;

    
    protected function afterSave(): void
    {
        $mahasiswa = MahasiswaModel::where('id_user', $this->record->id_user)->first();

        if ($mahasiswa) {
            $mahasiswa->update([
                'nim'       => $this->data['nim'],
                'id_prodi'  => $this->data['id_prodi'],
                'ipk'       => $this->data['ipk'],
                'semester'  => $this->data['semester'],
            ]);
        }
    } 

}
