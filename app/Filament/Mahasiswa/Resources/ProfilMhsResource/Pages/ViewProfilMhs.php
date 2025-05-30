<?php

namespace App\Filament\Mahasiswa\Resources\ProfilMhsResource\Pages;

use App\Filament\Mahasiswa\Resources\ProfilMhsResource;
use App\Models\Auth\MahasiswaModel;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;

class ViewProfilMhs extends Page
{
    protected static string $resource = ProfilMhsResource::class;

    protected static string $view = 'filament.mahasiswa.resources.profil-mhs-resource.pages.view-profil-mhs';

    protected static ?string $title = 'Profil Saya';

    protected static ?string $navigationLabel = 'Profil Saya';

    protected static ?string $slug = 'profil-saya';

    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('hapusFoto')
                ->label('Hapus Foto')
                ->color('danger')
                ->visible(fn() => filled($this->user->profile_picture))
                ->requiresConfirmation()
                ->modalHeading('Hapus Foto Profil')
                ->modalDescription('Apakah Anda yakin ingin menghapus foto profil?')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->action(function () {
                    // Hapus file dari storage
                    if ($this->user->profile_picture && Storage::disk('public')->exists($this->user->profile_picture)) {
                        Storage::disk('public')->delete($this->user->profile_picture);
                    }

                    // Update database
                    $this->user->update([
                        'profile_picture' => null,
                    ]);

                    // Refresh data
                    $this->user->refresh();

                    // Notifikasi
                    Notification::make()
                        ->title('Foto profil berhasil dihapus.')
                        ->success()
                        ->send();
                }),
        ];
    }
}
