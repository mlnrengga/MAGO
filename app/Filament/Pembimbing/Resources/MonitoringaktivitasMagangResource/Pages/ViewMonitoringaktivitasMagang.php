<?php

namespace App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource\Pages;

use App\Filament\Pembimbing\Resources\MonitoringaktivitasMagangResource;
use App\Models\Reference\LogMagangModel;
use Filament\Resources\Pages\ViewRecord;

class ViewMonitoringaktivitasMagang extends ViewRecord
{
    protected static string $resource = MonitoringaktivitasMagangResource::class;

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
