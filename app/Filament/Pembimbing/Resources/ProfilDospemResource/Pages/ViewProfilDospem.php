<?php

namespace App\Filament\Pembimbing\Resources\ProfilDospemResource\Pages;

use App\Filament\Pembimbing\Resources\ProfilDospemResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

// --- Import untuk INNOLISTS ---
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\ImageEntry; // Untuk menampilkan gambar
use Filament\Infolists\Infolist; // Wajib diimpor untuk Infolist

class ViewProfilDospem extends ViewRecord
{
    protected static string $resource = ProfilDospemResource::class;

    // Opsional: Atur judul halaman ini jika Anda ingin berbeda dari nama record

    protected static ?string $navigationLabel = 'Profil Saya';
    protected static ?string $title = 'Profil Saya'; // Sesuaikan dengan contoh mahasiswa Anda

    protected function getHeaderActions(): array
    {
        return [
            // Menambahkan tombol "Edit Profile" yang akan mengarahkan ke halaman edit
            Actions\EditAction::make(),
        ];
    }

    // *** INI ADALAH IMPLEMENTASI INNOLISTS untuk menampilkan data ***
    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Profil')
                    ->description('Detail pribadi dan kontak Anda.')
                    ->schema([
                        TextEntry::make('user.nama')
                            ->label('Nama'),
                        TextEntry::make('nip')
                            ->label('NIP'), // Sesuaikan label jika di database Anda ini NIP
                        TextEntry::make('user.no_telepon')
                            ->label('No. Telepon'),
                        TextEntry::make('user.alamat')
                            ->label('Alamat'),
                        ImageEntry::make('user.profile_picture')
                            ->label('Foto Profil')
                            ->disk('public'), // Pastikan ini sesuai dengan disk penyimpanan Anda (biasanya 'public')
                    ])->columns(2),

                Section::make('Bidang Keahlian')
                    ->description('Bidang keahlian yang relevan.')
                    ->schema([
                        TextEntry::make('bidangKeahlian.nama_bidang_keahlian')
                            ->label('Bidang Keahlian')
                            ->listWithLineBreaks() // Menampilkan multiple data di baris baru
                            ->bulleted(), // Opsional: menampilkan sebagai daftar bullet
                    ]),
                // Anda bisa menambahkan Section lain untuk "Pengalaman" dan "Dokumen" di sini
                // jika relasinya sudah ada di DosenPembimbingModel dan UserModel.
                // Contoh untuk Pengalaman (jika ada relasi 'pengalaman'):
                // Section::make('Pengalaman')
                //     ->schema([
                //         TextEntry::make('pengalaman')
                //             ->label('Detail Pengalaman'), // Ganti dengan relasi/kolom yang sesuai
                //     ]),
            ]);
    }
}