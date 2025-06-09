<?php

namespace App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource\Pages;

use App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource;
use App\Models\Reference\PenempatanMagangModel;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEvaluasiHasilMagang extends CreateRecord
{
    protected static string $resource = EvaluasiHasilMagangResource::class;
    
    protected static bool $canCreateAnother = false;
    
    // menyimpan data penempatan magang
    public $penempatan; // model
    public $id_penempatan; // id
    
    // Menerima parameter id_penempatan dari URL
    public function mount($id_penempatan = null): void
    {
        if (!$id_penempatan) {
            $this->redirect(EvaluasiHasilMagangResource::getUrl('index'));
            return;
        }

        parent::mount();
        
        // simpan ID ke properti
        $this->id_penempatan = $id_penempatan;

        // mengambil data penempatan untuk ditampilkan di form
        $this->penempatan = PenempatanMagangModel::with([
            'pengajuan.lowongan.perusahaan',
            'pengajuan.lowongan.jenisMagang',
            'pengajuan.lowongan.waktuMagang'
        ])->find($id_penempatan);
        
        if (!$this->penempatan) {
            $this->redirect(EvaluasiHasilMagangResource::getUrl('index'));
            return;
        }
        
        // pre-fill form dengan id_penempatan
        $this->form->fill([
            'id_penempatan' => $this->id_penempatan,
            'tanggal_upload' => now(),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['id_penempatan'] = $this->id_penempatan;
        return $data;
    }
    
    // override untuk menghilangkan breadcrumb "Create"
    public function getBreadcrumb(): string
    {
        return 'Tambah Evaluasi';
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
