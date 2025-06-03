<?php

namespace App\Filament\Mahasiswa\Resources\PengajuanMagangMahasiswaResource\Pages;

use App\Filament\Mahasiswa\Resources\PengajuanMagangMahasiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\Request;

class CreatePengajuanMagangMahasiswa extends CreateRecord
{
    protected static string $resource = PengajuanMagangMahasiswaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['tanggal_pengajuan'])) {
            $data['tanggal_pengajuan'] = now()->format('Y-m-d');
        }

        if (!isset($data['id_mahasiswa'])) {
            $data['id_mahasiswa'] = auth()->user()->mahasiswa->id_mahasiswa;
        }

        if (!isset($data['status'])) {
            $data['status'] = 'Diajukan';
        }

        return $data;
    }

    public function mount(): void
    {
        $request = app(Request::class);
        $lowongan_id = $request->query('id_lowongan');

        parent::mount();

        if ($lowongan_id) {
            $this->form->fill([
                'id_lowongan' => $lowongan_id,
                'tanggal_pengajuan' => now(),
                'id_mahasiswa' => auth()->user()->mahasiswa->id_mahasiswa,
                'status' => 'Diajukan',
            ]);

            $this->dispatch('$refresh');
        }
    }

    protected function afterMount(): void
    {
        $request = app(Request::class);
        $lowongan_id = $request->query('id_lowongan');

        if ($lowongan_id) {
            $this->evaluate();
        }
    }

    protected function evaluate(): void
    {
        $state = $this->form->getState();

        $this->form->fill($state);
    }
}
