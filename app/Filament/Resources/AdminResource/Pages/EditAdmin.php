<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use App\Models\Auth\MahasiswaModel;
use App\Models\Auth\AdminModel;
use App\Models\Auth\DosenPembimbingModel;
use Filament\Resources\Pages\EditRecord;


class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->record->load(['mahasiswa', 'admin', 'dosenPembimbing']);

        if ($record->id_role == 2 && $record->mahasiswa) {
            $data['mahasiswa']['nim'] = $record->mahasiswa->nim;
        }

        if ($record->id_role == 1 && $record->admin) {
            $data['admin']['nip'] = $record->admin->nip;
        }

        if ($record->id_role == 3 && $record->dosenPembimbing) {
            $data['dosenPembimbing']['nip'] = $record->dosenPembimbing->nip;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $user = $this->record;
        $roleId = $user->id_role;

        $mahasiswaInput = $this->data['mahasiswa']['nim'] ?? null;
        $adminInput = $this->data['admin']['nip'] ?? null;
        $dospemInput = $this->data['dosenPembimbing']['nip'] ?? null;

        if ($roleId == 2) {
            MahasiswaModel::updateOrCreate(
                ['id_user' => $user->id_user],
                ['nim' => $mahasiswaInput, 'id_prodi' => 1, 'ipk' => 0, 'semester' => 1]
            );
        } elseif ($roleId == 1) {
            AdminModel::updateOrCreate(
                ['id_user' => $user->id_user],
                ['nip' => $adminInput]
            );
        } elseif ($roleId == 3) {
            DosenPembimbingModel::updateOrCreate(
                ['id_user' => $user->id_user],
                ['nip' => $dospemInput]
            );
        }
    }
}
