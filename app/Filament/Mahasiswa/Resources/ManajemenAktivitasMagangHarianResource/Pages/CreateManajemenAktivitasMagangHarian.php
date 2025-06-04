<?php

// // namespace App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;

// // use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource;
// // use App\Models\Reference\PenempatanMagangModel;
// // use Filament\Resources\Pages\CreateRecord;
// // use Illuminate\Support\Facades\Session;

// // class CreateManajemenAktivitasMagangHarian extends CreateRecord
// // {
// //     protected static string $resource = ManajemenAktivitasMagangHarianResource::class;
    
// //     protected ?int $penempatanId = null;
    
// //     public function mount(): void
// //     {
// //         // Ambil penempatanId dari request atau session
// //         $this->penempatanId = request('penempatanId');
        
// //         // Redirect jika tidak ada penempatanId
// //         if (!$this->penempatanId) {
// //             $this->redirect($this->getResource()::getUrl('index'));
// //             return;
// //         }
        
// //         parent::mount();
// //     }
    
// //     protected function mutateFormDataBeforeCreate(array $data): array
// //     {
// //         // Pastikan id_penempatan terisi
// //         $data['id_penempatan'] = $this->penempatanId;
// //         return $data;
// //     }
    
// //     protected function getRedirectUrl(): string
// //     {
// //         return $this->getResource()::getUrl('index', ['penempatanId' => $this->penempatanId]);
// //     }
// // }

namespace App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource\Pages;

use App\Filament\Mahasiswa\Resources\ManajemenAktivitasMagangHarianResource;
use App\Models\Reference\PenempatanMagangModel;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Session;

class CreateManajemenAktivitasMagangHarian extends CreateRecord
{
    protected static string $resource = ManajemenAktivitasMagangHarianResource::class;

    protected ?int $penempatanId = null;

    // PENTING! menyimpan id di session untuk digunakan di seluruh halaman
    public function boot(): void
    {
        // Simpan penempatanId di session jika ada di parameter URL
        $requestPenempatanId = request('penempatanId');
        if ($requestPenempatanId) {
            Session::put('current_penempatan_id', $requestPenempatanId);
        }
        
        // Ambil penempatanId dari session jika ada
        $this->penempatanId = Session::get('current_penempatan_id');
    }

    // Validasi sebelum mount
    public function mount(): void
    {
        if (!$this->penempatanId) {
            // Redirect jika tidak ada penempatanId
            $this->redirect($this->getResource()::getUrl('index'));
            return;
        }
        
        parent::mount();
    }
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Memastikan id_penempatan diisi
        $data['id_penempatan'] = $this->penempatanId;

        // Memastikan tanggal_log diisi jika kosong
        if (!isset($data['tanggal_log']) || empty($data['tanggal_log'])) {
            $data['tanggal_log'] = now();
        }
        
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index', ['penempatanId' => $this->penempatanId]);
    }

    public function getSubheading(): string|Htmlable|null
    {
        if ($this->penempatanId) {
            // $penempatanModel = app(PenempatanMagangModel::class);
            // $penempatan = $penempatanModel->with('pengajuan.lowongan')
            //     ->find($this->penempatanId);
            $penempatan = PenempatanMagangModel::with('pengajuan.lowongan')
                ->find($this->penempatanId);
            
            if ($penempatan && $penempatan->pengajuan && $penempatan->pengajuan->lowongan) {
                return 'Menambahkan aktivitas untuk lowongan: ' . $penempatan->pengajuan->lowongan->judul_lowongan;
            }
        }
        
        return parent::getSubheading();
    }
}