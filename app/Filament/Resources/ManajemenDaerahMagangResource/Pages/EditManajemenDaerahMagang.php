<?php

namespace App\Filament\Resources\ManajemenDaerahMagangResource\Pages;

use App\Filament\Resources\ManajemenDaerahMagangResource;
use App\Models\Reference\DaerahMagangModel;
use App\Models\Reference\ProvinsiModel;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditManajemenDaerahMagang extends EditRecord
{
    protected static string $resource = ManajemenDaerahMagangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function beforeSave(): void
    {
        $data = $this->form->getState();
        
        $normalizedInput = strtolower(preg_replace('/\s+/', '', $data['nama_daerah']));
        $jenisDaerah = $data['jenis_daerah'];
        $namaDaerah = $data['nama_daerah'];
        
        $exists = DaerahMagangModel::query()
            ->whereRaw("REPLACE(LOWER(nama_daerah), ' ', '') = ?", [$normalizedInput])
            ->where('jenis_daerah', $jenisDaerah)
            ->where('id_daerah_magang', '!=', $this->record->id_daerah_magang)
            ->exists();
        
        if ($exists) {
            $this->addError('data.nama_daerah', "Nama daerah \"{$namaDaerah}\" sudah terdaftar dengan jenis daerah \"{$jenisDaerah}\".");
            $this->addError('data.jenis_daerah', "Jenis daerah \"{$jenisDaerah}\" sudah terdaftar dengan nama daerah \"{$namaDaerah}\".");
            
            $this->halt();
        }
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ambil hasil nominatim dan tambahkan ke data
        $searchQuery = $data['nama_daerah'];
        if ($data['jenis_daerah']) {
            $searchQuery .= " " . $data['jenis_daerah'];
        }
        
        if (!empty($data['id_provinsi'])) {
            $provinsi = ProvinsiModel::find($data['id_provinsi']);
            if ($provinsi) {
                $searchQuery .= " " . $provinsi->nama_provinsi . " Indonesia";
            } else {
                $searchQuery .= " Indonesia";
            }
        } else {
            $searchQuery .= " Indonesia";
        }

        $result = $this->searchNominatim($searchQuery);
        
        if (empty($result)) {
            $this->addError('data.nama_daerah', "Nama {$data['jenis_daerah']} \"{$data['nama_daerah']}\" tidak ditemukan pada peta. Mohon periksa penulisan nama daerah atau coba gunakan nama yang lebih umum.");
            $this->halt();
            return []; // tidak akan dijalankan karena halt() sudah dipanggil
        }

        $data['latitude'] = (float)$result['lat'];
        $data['longitude'] = (float)$result['lon'];
        
        return $data;
    }

    protected function searchNominatim(string $query): ?array
    {
        $endpoint = "https://nominatim.openstreetmap.org/search";
        $params = [
            'q' => $query,
            'format' => 'json',
            'addressdetails' => 1,
            'limit' => 1,
        ];
        
        $url = $endpoint . '?' . http_build_query($params);
        
        // User agent sesuai dengan ketentuan nominatim
        $options = [
            'http' => [
                'header' => "User-Agent: MAGO/1.0\r\n",
                'method' => 'GET'
            ]
        ];
        
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        
        if ($response === false) {
            return null;
        }
        
        $data = json_decode($response, true);
        
        // kembalikan null jika tidak berhasil
        if (empty($data)) {
            return null;
        }
        
        // kembalikan hasil data pertama
        return $data[0];
    }

}
