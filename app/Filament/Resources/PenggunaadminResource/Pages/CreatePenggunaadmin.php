<?php

namespace App\Filament\Resources\PenggunaadminResource\Pages;

use App\Filament\Resources\PenggunaadminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use App\Models\Auth\AdminModel;

class CreatePenggunaadmin extends CreateRecord
{
    protected static string $resource = PenggunaadminResource::class;

    protected function afterCreate(): void
    {
        AdminModel::create([
            'id_user' => $this->record->id_user,
            'nip' => $this->data['nip'],
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
