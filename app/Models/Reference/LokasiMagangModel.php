<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiMagangModel extends Model
{
    use HasFactory;

    // m_lokasi_magang
    // + id_lokasi_magang: int (PK)
    // + alamat_lokasi_magang: String

    protected $table = 'm_lokasi_magang';
    protected $primaryKey = 'id_lokasi_magang';
    protected $fillable = [
        "kota_lokasi_magang",
    ];

    public function preferensiMahasiswa()
    {
        return $this->hasMany(PreferensiMahasiswaModel::class, 'id_lokasi_magang');
    }

    public function dosenPembimbing()
    {
        return $this->hasMany(DosenPembimbingModel::class, 'id_lokasi_magang');
    }
}
