<?php

namespace App\Filament\Mahasiswa\Resources\AktivitasMagangHarianResource\Pages;

use App\Filament\Mahasiswa\Resources\AktivitasMagangHarianResource;
use App\Models\Reference\LowonganMagangModel;
use App\Models\Reference\PengajuanMagangModel;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CreateAktivitasMagangHarian extends CreateRecord
{
    protected static string $resource = AktivitasMagangHarianResource::class;

    // variabel switch untuk mengontrol proses "create and create another"
    protected bool $shouldCreateAnother = false;
    
    protected function getRedirectUrl(): string
    {
        // jika "create and create another", maka gunakan perilaku default
        if ($this->shouldCreateAnother) {
            return $this->getResource()::getUrl('create');
        }
        
        // Untuk tombol "Create", buat URL filter
        return $this->getFilteredUrl();
    }
    
    // override metode create untuk menangkap tombol yang ditekan
    public function create(bool $another = false): void
    {
        $this->shouldCreateAnother = $another;
        parent::create($another);
    }

    // override metode createAnother untuk menandai bahwa ini adalah "Create and Create Another"
    public function createAnother(): void
    {
        $this->create(true);
    }
    
    protected function afterCreate(): void
    {
        // notifikasi sukses
        Notification::make()
            ->title('Aktivitas magang berhasil ditambahkan')
            ->success()
            ->send();
    }

    // mematikan notifikasi bawaan
    protected function getCreatedNotificationTitle(): ?string
    {
        return null; 
    }
    
    // Helper function untuk membuat url filter
    protected function getFilteredUrl(): string
    {
        // mengambil data untuk filter
        $formState = $this->form->getState();
        $idLowongan = $formState['id_lowongan'] ?? null;
        
        // jika tidak ada lowongan, kembali ke index tanpa filter
        if (!$idLowongan) {
            return static::getResource()::getUrl('index');
        }
        
        // mengambil tanggal mulai dan selesai berdasarkan lowongan
        $dariTanggal = Carbon::now()->format('Y-m-d'); 
        $sampaiTanggal = Carbon::now()->addMonths(6)->format('Y-m-d');
        
        // mencari tanggal yang sebenarnya dari data pengajuan
        $userId = Auth::id();
        $pengajuan = PengajuanMagangModel::where('id_lowongan', $idLowongan)
            ->whereHas('mahasiswa', function (Builder $query) use ($userId) {
                $query->whereHas('user', function (Builder $query) use ($userId) {
                    $query->where('id_user', $userId);
                });
            })
            ->where('status', 'Diterima')
            ->first();
        
        if ($pengajuan && $pengajuan->tanggal_diterima) {
            $dariTanggal = Carbon::parse($pengajuan->tanggal_diterima)->format('Y-m-d');
            
            // mengambil waktu magang dari lowongan
            $lowongan = LowonganMagangModel::with('waktuMagang')->find($idLowongan);
            if ($lowongan && $lowongan->waktuMagang) {
                // Ekstrak angka bulan dari string waktu magang
                preg_match('/(\d+)/', $lowongan->waktuMagang->waktu_magang, $matches);
                if (isset($matches[1])) {
                    $bulan = (int)$matches[1];
                    $sampaiTanggal = Carbon::parse($pengajuan->tanggal_diterima)
                        ->addMonths($bulan)
                        ->format('Y-m-d');
                }
            }
        }
        
        // Format URL yang benar untuk filter
        $baseUrl = static::getResource()::getUrl('index');
        return "{$baseUrl}?tableFilters[filter_lowongan_magang][id_lowongan]={$idLowongan}" . 
               "&tableFilters[filter_lowongan_magang][dari_tanggal]={$dariTanggal}" . 
               "&tableFilters[filter_lowongan_magang][sampai_tanggal]={$sampaiTanggal}";
    }
}