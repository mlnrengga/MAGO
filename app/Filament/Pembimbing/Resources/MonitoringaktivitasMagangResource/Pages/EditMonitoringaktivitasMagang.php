<?php

namespace App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource;
use App\Models\Reference\LogMagangModel;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonitoringaktivitasMagang extends EditRecord
{
    protected static string $resource = MonitoringaktivitasMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // ✅ Agar relasi dimuat
    protected function resolveRecordUsing($key): \Illuminate\Database\Eloquent\Model
    {
        return LogMagangModel::with(['penempatan.mahasiswa.user'])->findOrFail($key);
    }

    // ✅ Tambahan agar field nama_mahasiswa diisi otomatis
    protected function afterFormFilled(): void
    {
        $this->form->fill([
            'nama_mahasiswa' => optional($this->record->penempatan?->mahasiswa?->user)->nama ?? '-',
        ]);
    }
}
