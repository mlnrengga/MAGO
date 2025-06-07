<?php

namespace App\Filament\Resources\PenggunaDospemResource\Pages;

use App\Filament\Resources\PenggunaDospemResource;
use App\Models\Auth\DosenPembimbingModel;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditPenggunaDospem extends EditRecord
{
    protected static string $resource = PenggunaDospemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $user = $this->record;
        $dosenPembimbing = $user->dosenPembimbing;
        
        if ($dosenPembimbing) {
            $data['nip'] = $dosenPembimbing->nip;
        }
        
        return $data;
    }
    
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $nip = $data['nip'] ?? null;
        unset($data['nip']);
        
        $user = parent::handleRecordUpdate($record, $data);
        
        DosenPembimbingModel::updateOrCreate(
            ['id_user' => $user->id_user],
            ['nip' => $nip]
        );
        
        return $user;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
