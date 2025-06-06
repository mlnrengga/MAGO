<?php

namespace App\Filament\Resources\PenggunaDospemResource\Pages;

use App\Filament\Resources\PenggunaDospemResource;
use App\Models\Auth\DosenPembimbingModel;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePenggunaDospem extends CreateRecord
{
    protected static string $resource = PenggunaDospemResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $nip = $data['nip'] ?? null;
        unset($data['nip']);
        
        $user = parent::handleRecordCreation($data);
        
        DosenPembimbingModel::create([
            'id_user' => $user->id_user,
            'nip' => $nip,
        ]);
        
        return $user;
    }
}
