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
        $user = $this->record;
        $roleId = $user->id_role;

        $mahasiswaInput = $this->data['mahasiswa']['nim'] ?? null;
        $adminInput = $this->data['admin']['nip'] ?? null;
        $dospemInput = $this->data['dosenPembimbing']['nip'] ?? null;

        if ($roleId == 2) {
            MahasiswaModel::create([
                'id_user' => $user->id_user,
                'nim' => $mahasiswaInput,
                'id_prodi' => 1,
                'ipk' => 0,
                'semester' => 1,
            ]);
        } elseif ($roleId == 1) {
            AdminModel::create([
                'id_user' => $user->id_user,
                'nip' => $adminInput,
            ]);
        } elseif ($roleId == 3) {
            DosenPembimbingModel::create([
                'id_user' => $user->id_user,
                'nip' => $dospemInput,
            ]);
        }
    }
}
