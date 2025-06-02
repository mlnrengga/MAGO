<?php

namespace App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;

use App\Filament\Pembimbing\Resources\ProfilDospemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model; // Pastikan ini di-import
use Illuminate\Support\Facades\DB;     // Pastikan ini di-import untuk transaksi database

class EditProfilDospem extends EditRecord
{
    protected static string $resource = ProfilDospemResource::class;

    protected function handleRecordUpdate(Model $record, array $data): Model
    {

        return DB::transaction(function () use ($record, $data) {
            // Ekstrak data user
            $userData = $data['user'];
            unset($data['user']); // Hapus dari array data utama

            $userModel = $record->user; // Ambil model user terkait

            if ($userModel) {
                // Perbarui atribut user
                $userModel->nama = $userData['nama'];
                $userModel->no_telepon = $userData['no_telepon'];
                $userModel->alamat = $userData['alamat'];

                // Tangani password (jika diisi)
                if (!empty($userData['password'])) {
                    $userModel->password = $userData['password']; // Password sudah di-hash oleh TextInput
                }

                // Tangani foto profil
                if (isset($userData['profile_picture'])) {
                    $userModel->profile_picture = $userData['profile_picture'];
                } else {
                    $userModel->profile_picture = null;
                }

                $userModel->save(); // <<< INI YANG SEKARANG AKAN TERJALANKAN
            }

            // DosenPembimbingModel tidak memiliki field yang diupdate langsung dari form ini
            // Relasi bidangKeahlian ditangani otomatis oleh Filament
            return $record; // Kembalikan record utama
        });
    }
    protected static ?string $title = 'Edit Profil & Akun';

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
    // public function getRecord(): Model
    // {
    //     // Pastikan user sudah login dan memiliki relasi dosenPembimbing
    //     $user = Auth::user();
    //     if (!$user || !$user->dosenPembimbing) {
    //         abort(404, 'Profil Dosen Pembimbing tidak ditemukan.'); // Atau redirect ke halaman lain
    //     }
    //     return $user->dosenPembimbing;
    // }

    /**
     * Mengarahkan kembali ke halaman profil setelah sukses update.
     *
     * @return string|\Illuminate\Http\RedirectResponse
     */
    protected function getRedirectUrl(): ?string
{
    // Gunakan getKey() untuk mendapatkan primary key yang benar (id_dospem)
    return static::getResource()::getUrl('view', ['record' => $this->getRecord()->getKey()]);
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