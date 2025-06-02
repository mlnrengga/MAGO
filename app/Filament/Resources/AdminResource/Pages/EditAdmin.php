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
            $data['extra']['nim'] = $record->mahasiswa->nim;
        }

        if (in_array($record->id_role, [1, 3])) {
            $data['extra']['nip'] = $record->admin?->nip ?? $record->dosenPembimbing?->nip;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $user = $this->record;
        $roleId = $user->id_role;
        $extra = $this->data['extra'] ?? [];

        if ($roleId == 2) { // Mahasiswa
            $mahasiswa = MahasiswaModel::where('id_user', $user->id_user)->first();
            if ($mahasiswa) {
                $mahasiswa->update(['nim' => $extra['nim'] ?? null]);
            } else {
                MahasiswaModel::create([
                    'id_user' => $user->id_user,
                    'nim' => $extra['nim'] ?? null,
                    'id_prodi' => 1,
                    'ipk' => 0,
                    'semester' => 1,
                ]);
            }
        } elseif ($roleId == 1) { // Admin
            $admin = AdminModel::where('id_user', $user->id_user)->first();
            if ($admin) {
                $admin->update(['nip' => $extra['nip'] ?? null]);
            } else {
                AdminModel::create([
                    'id_user' => $user->id_user,
                    'nip' => $extra['nip'] ?? null,
                ]);
            }
        } elseif ($roleId == 3) { // Dosen Pembimbing
            $dospem = DosenPembimbingModel::where('id_user', $user->id_user)->first();
            if ($dospem) {
                $dospem->update(['nip' => $extra['nip'] ?? null]);
            } else {
                DosenPembimbingModel::create([
                    'id_user' => $user->id_user,
                    'nip' => $extra['nip'] ?? null,
                ]);
            }
        }
    }
}
