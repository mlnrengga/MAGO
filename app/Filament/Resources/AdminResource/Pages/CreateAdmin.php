<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use App\Models\Auth\MahasiswaModel;
use App\Models\Auth\AdminModel;
use App\Models\Auth\DosenPembimbingModel;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected function afterCreate(): void
    {
        $user = $this->record; // data yang baru disimpan di m_user
        $roleId = $user->id_role;

        if ($roleId == 2) { // Mahasiswa
            MahasiswaModel::create([
                'id_user' => $user->id_user,
                'nim' => $this->data['nim'],
                'id_prodi' => 1,
                'ipk' => 0,
                'semester' => 1,
            ]);
        } elseif ($roleId == 1) { // Admin
            AdminModel::create([
                'id_user' => $user->id_user,
                'nip' => $this->data['nip'],
            ]);
        } elseif ($roleId == 3) { // Dosen Pembimbing
            DosenPembimbingModel::create([
                'id_user' => $user->id_user,
                'nip' => $this->data['nip'],
            ]);
        }
    }
}
