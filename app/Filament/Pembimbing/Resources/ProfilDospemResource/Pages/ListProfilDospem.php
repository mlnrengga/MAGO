<?php

namespace App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;

use App\Filament\Pembimbing\Resources\ProfilDospemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListProfilDospem extends ListRecords
{
    protected static string $resource = ProfilDospemResource::class;

    public function mount(): void
    {
        $dosenPembimbing = Auth::user()?->dosenPembimbing;

        if ($dosenPembimbing) {
            $this->redirect(ProfilDospemResource::getUrl('view', ['record' => $dosenPembimbing->id_dospem]));
        }
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
