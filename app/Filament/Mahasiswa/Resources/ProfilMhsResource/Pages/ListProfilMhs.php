<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use App\Models\Auth\MahasiswaModel;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListProfilMhs extends ListRecords
{
    protected static string $resource = ProfilMhsResource::class;

    public function mount(): void
    {
        $mahasiswa = Auth::user()?->mahasiswa;

        if ($mahasiswa) {
            $this->redirect(ProfilMhsResource::getUrl('view', ['record' => $mahasiswa->id_mahasiswa]));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
