<?php

namespace App\Filament\Resources\KegiatanMagangResource\Pages;

use App\Filament\Resources\KegiatanMagangResource;
use App\Models\Reference\PenempatanMagangModel;
use App\Models\Reference\PengajuanMagangModel;
use App\Models\UserModel;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;

class EditKegiatanMagang extends EditRecord
{
    protected static string $resource = KegiatanMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->modalHeading('Hapus Pengajuan Magang')
                ->modalDescription('Apakah Anda yakin ingin menghapus pengajuan magang ini? Jika pengajuan sudah diterima, data penempatan magang terkait juga akan dihapus.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal')
                ->before(function (PengajuanMagangModel $record) {
                    if ($record->penempatan) {
                        DB::table('r_bimbingan')
                            ->where('id_penempatan', $record->penempatan->id_penempatan)
                            ->delete();

                        $record->penempatan->delete();
                    }
                }),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        $record = $this->record;

        // Get the student user model
        $mahasiswa = UserModel::whereHas('mahasiswa', function ($query) use ($record) {
            $query->where('id_mahasiswa', $record->id_mahasiswa);
        })->first();

        if ($record->status === 'Diterima') {
            $dosenPembimbing = $this->data['dosen_pembimbing'] ?? null;
            $dosenPembimbingNama = null;
            $dosenUser = null;

            if ($dosenPembimbing) {
                $dosenUser = UserModel::whereHas('dosenPembimbing', function ($query) use ($dosenPembimbing) {
                    $query->where('id_dospem', $dosenPembimbing);
                })->first();

                if ($dosenUser) {
                    $dosenPembimbingNama = $dosenUser->nama;
                }
            }

            if ($dosenUser) {
                Notification::make()
                    ->title('Pengajuan Magang Diterima')
                    ->body('Anda telah ditunjuk sebagai dosen pembimbing untuk mahasiswa ' . ($mahasiswa->nama ?? '-') . ' pada pengajuan magang berjudul "' . ($record->lowongan->judul_lowongan ?? '-') . '".')
                    ->success()
                    ->persistent()
                    ->icon('heroicon-o-check-circle')
                    ->sendToDatabase($dosenUser);
            }

            if ($mahasiswa) {
                Notification::make()
                    ->title('Pengajuan Magang Diterima')
                    ->body('Selamat! Pengajuan magang Anda telah diterima di ' . ($record->lowongan->judul_lowongan ?? '-') .
                        ($dosenPembimbingNama ? '. Dosen pembimbing Anda adalah ' . $dosenPembimbingNama : ''))
                    ->success()
                    ->persistent()
                    ->icon('heroicon-o-check-circle')
                    ->sendToDatabase($mahasiswa);
            }

            $penempatan = PenempatanMagangModel::where('id_pengajuan', $record->id_pengajuan)->first();

            DB::beginTransaction();
            try {
                if (!$penempatan) {
                    $penempatan = PenempatanMagangModel::create([
                        'id_mahasiswa' => $record->id_mahasiswa,
                        'id_pengajuan' => $record->id_pengajuan,
                        'status' => PenempatanMagangModel::STATUS_BERLANGSUNG,
                    ]);

                    if ($dosenPembimbing) {
                        DB::table('r_bimbingan')->insert([
                            'id_dospem' => $dosenPembimbing,
                            'id_penempatan' => $penempatan->id_penempatan,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    DB::commit();

                    $admin = auth()->user();
                    Notification::make()
                        ->title('Penempatan magang berhasil dibuat')
                        ->success()
                        ->persistent()
                        ->icon('heroicon-o-check-circle')
                        ->sendToDatabase($admin);
                }
            } catch (\Exception $e) {
                DB::rollBack();

                Notification::make()
                    ->title('Error membuat penempatan magang')
                    ->body($e->getMessage())
                    ->danger()
                    ->persistent()
                    ->send();
                return;
            }
        } elseif ($record->status === 'Ditolak') {
            // Create notification for rejected application
            if ($mahasiswa) {
                Notification::make()
                    ->title('Pengajuan Magang Ditolak')
                    ->body('Maaf, pengajuan magang ' . ($record->lowongan->judul_lowongan ?? '-') . ' Anda telah ditolak.')
                    ->danger()
                    ->persistent()
                    ->icon('heroicon-o-x-circle')
                    ->sendToDatabase($mahasiswa);
            }
        }
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->data = $data;

        if (isset($data['dosen_pembimbing'])) {
            unset($data['dosen_pembimbing']);
        }

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        if ($record->penempatan) {
            $dosenPembimbing = DB::table('r_bimbingan')
                ->where('id_penempatan', $record->penempatan->id_penempatan)
                ->first();

            if ($dosenPembimbing) {
                $data['dosen_pembimbing'] = $dosenPembimbing->id_dospem;
            }
        }

        return $data;
    }
}
