<?php

namespace App\Filament\Resources\AdminResource\Pages;


use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\AdminResource;
use App\Models\Auth\MahasiswaModel;
use App\Models\Auth\AdminModel;
use App\Models\Auth\DosenPembimbingModel;
class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function afterSave(): void
    {
        $user = $this->record;
        $roleId = $user->id_role;

        if ($roleId == 2) { // Mahasiswa
            $mahasiswa = MahasiswaModel::where('id_user', $user->id_user)->first();
            if ($mahasiswa) {
                $mahasiswa->update([
                    'nim' => $this->data['nim'],
                ]);
            } else {
                MahasiswaModel::create([
                    'id_user' => $user->id_user,
                    'nim' => $this->data['nim'],
                    'id_prodi' => 1,
                    'ipk' => 0,
                    'semester' => 1,
                ]);
            }
        } elseif ($roleId == 1) { // Admin
            $admin = AdminModel::where('id_user', $user->id_user)->first();
            if ($admin) {
                $admin->update(['nip' => $this->data['nip']]);
            } else {
                AdminModel::create([
                    'id_user' => $user->id_user,
                    'nip' => $this->data['nip'],
                ]);
            }
        } elseif ($roleId == 3) { // Dosen Pembimbing
            $dospem = DosenPembimbingModel::where('id_user', $user->id_user)->first();
            if ($dospem) {
                $dospem->update(['nip' => $this->data['nip']]);
            } else {
                DosenPembimbingModel::create([
                    'id_user' => $user->id_user,
                    'nip' => $this->data['nip'],
                ]);
            }
        }
    }
}
