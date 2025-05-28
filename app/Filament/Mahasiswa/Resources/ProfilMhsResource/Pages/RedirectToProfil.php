<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use Filament\Resources\Pages\Page;

class RedirectToProfil extends Page
{
    protected static string $resource = ProfilMhsResource::class;

    protected static string $view = 'filament::blank';

    public function mount()
    {
        return redirect()->route('filament.mahasiswa.resources.profil-mhs.profil');
    }
}
