<?php

namespace App\Models\Pivot;

use App\Models\Auth\MahasiswaModel;
use App\Models\Reference\BidangKeahlianModel;
use App\Models\Reference\JenisMagangModel;
use App\Models\Reference\LokasiMagangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'r_preferensi_mahasiswa';
    protected $primaryKey = 'id_preferensi';
    protected $fillable = [
        'id_mahasiswa',
        'id_bidang_keahlian',
        'ranking_bidang',
        'id_lokasi_magang',
        'ranking_lokasi',
        'id_jenis_magang',
        'ranking_jenis',
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa');
    }

    // Relasi ke bidang keahlian
    public function bidangKeahlian()
    {
        return $this->belongsTo(BidangKeahlianModel::class, 'id_bidang_keahlian');
    }

    // Relasi ke lokasi magang
    public function lokasiMagang()
    {
        return $this->belongsTo(LokasiMagangModel::class, 'id_lokasi_magang');
    }

    // Relasi ke jenis magang
    public function jenisMagang()
    {
        return $this->belongsTo(JenisMagangModel::class, 'id_jenis_magang');
    }
}
