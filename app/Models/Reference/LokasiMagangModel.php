<?php

namespace App\Models\Reference;

use App\Models\Auth\DosenPembimbingModel;
use App\Models\Pivot\PreferensiMahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LokasiMagangModel extends Model
{
    use HasFactory;

    // m_lokasi_magang
    // + id_lokasi_magang: int (PK)
    // + alamat_lokasi_magang: String

    protected $table = 'm_lokasi_magang';
    protected $primaryKey = 'id_lokasi_magang';
    protected $fillable = [
        "nama_lokasi",
    ];

    public function preferensiMahasiswa()
    {
        return $this->hasMany(PreferensiMahasiswaModel::class, 'id_lokasi_magang');
    }

    public function lowonganMagang(): HasOne
    {
        return $this->hasOne(LowonganMagangModel::class, 'id_lokasi_magang', 'id_lokasi_magang');
    }
}
