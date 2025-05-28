<?php

namespace App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;

use App\Filament\Pembimbing\Resources\ProfilDospemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Http\RedirectResponse; // Import RedirectResponse

class EditProfilDospem extends EditRecord
{
    protected static string $resource = ProfilDospemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Anda bisa menambahkan Actions lain di sini jika perlu
        ];
    }

    /**
     * Mengambil record Dosen Pembimbing yang sedang login.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getRecord(): Model
    {
        // Pastikan user sudah login dan memiliki relasi dosenPembimbing
        $user = Auth::user();
        if (!$user || !$user->dosenPembimbing) {
            abort(404, 'Profil Dosen Pembimbing tidak ditemukan.'); // Atau redirect ke halaman lain
        }
        return $user->dosenPembimbing;
    }

    /**
     * Mengarahkan kembali ke halaman profil setelah sukses update.
     *
     * @return string|\Illuminate\Http\RedirectResponse
     */
    protected function getRedirectUrl(): ?string
    {
        return static::getResource()::getUrl('profile'); // Kembalikan string URL
    }

    /**
     * Mengatur pesan sukses setelah update.
     *
     * @return string|null
     */
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Profil Dosen Pembimbing berhasil diperbarui';
    }
}