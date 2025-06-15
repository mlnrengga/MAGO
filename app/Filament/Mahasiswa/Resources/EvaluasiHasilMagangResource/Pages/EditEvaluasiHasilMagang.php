<?php

namespace App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource\Pages;

use App\Filament\Mahasiswa\Resources\EvaluasiHasilMagangResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditEvaluasiHasilMagang extends EditRecord
{
    protected static string $resource = EvaluasiHasilMagangResource::class;
    
    // Menyimpan data penempatan magang
    public $penempatan;
    
    public function mount($record): void
    {
        parent::mount($record);
        
        // Ambil data penempatan untuk ditampilkan di form
        $this->penempatan = $this->record->penempatanMagang;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
                ->title('Evaluasi magang berhasil diperbarui')
                ->success()
                ->send();
    }

    protected function afterSave(): void
    {
        // Pastikan status penempatan magang adalah "Selesai"
        if ($this->penempatan && $this->penempatan->status !== 'Selesai') {
            $this->penempatan->update([
                'status' => 'Selesai'
            ]);
            
            // Opsional: Tambahkan notifikasi berhasil update status
            Notification::make()
                ->title('Status magang berhasil diperbarui')
                ->success()
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-o-arrow-left')
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
            
            Actions\DeleteAction::make()
                ->before(function () {
                    // mengambil ID penempatan sebelum dihapus
                    $id_penempatan = $this->record->id_penempatan;
                    
                    // simpan ke session 
                    session(['deleted_penempatan_id' => $id_penempatan]);
                })
                ->after(function () {
                    // mengambil ID penempatan dari session
                    $id_penempatan = session('deleted_penempatan_id');
                    
                    if ($id_penempatan) {
                        //  update status penempatan magangnya ke "Berlangsung"
                        $penempatan = \App\Models\Reference\PenempatanMagangModel::find($id_penempatan);
                        
                        if ($penempatan) {
                            $penempatan->update([
                                'status' => 'Berlangsung'
                            ]);
                            
                            // hapus sessionnya
                            session()->forget('deleted_penempatan_id');
                            
                            // notif status berhasil diubah
                            Notification::make()
                                ->title('Status magang anda menjadi "Berlangsung" karena evaluasi dihapus.')
                                ->success()
                                ->send();
                        }
                    }
                })
                ->successNotification(null),
        ];
    }
    
    // Override untuk mengubah breadcrumb "Edit"
    public function getBreadcrumb(): string
    {
        return 'Ubah Evaluasi';
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
