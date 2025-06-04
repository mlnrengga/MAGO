<?php

namespace App\Filament\Resources\PenggunaadminResource\Pages;

use App\Filament\Resources\PenggunaadminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenggunaadmin extends EditRecord
{
    protected static string $resource = PenggunaadminResource::class;

    protected function afterSave(): void
    {
        $admin = $this->record->admin;

        if ($admin) {
            $admin->update([
                'nip' => $this->data['nip'],
            ]);
        }
    }
}
