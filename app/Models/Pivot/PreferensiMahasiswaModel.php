<?php

namespace App\Models\Pivot;

use App\Models\Auth\MahasiswaModel;
use App\Models\Reference\BidangKeahlianModel;
use App\Models\Reference\DaerahMagangModel;
use App\Models\Reference\InsentifModel;
use App\Models\Reference\JenisMagangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'r_preferensi_mahasiswa';
    protected $primaryKey = 'id_preferensi';
    protected $fillable = [
        'id_mahasiswa',
        'id_bidang',
        'ranking_bidang',
        'id_lokasi_magang',
        'ranking_lokasi',
        'id_jenis_magang',
        'ranking_jenis',
        'id_insentif',
        'ranking_insentif',
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa');
    }

    // Relasi ke bidang keahlian
    public function bidangKeahlian()
    {
        return $this->belongsTo(BidangKeahlianModel::class, 'id_bidang');
    }

    // Relasi ke daerah magang
    public function daerahMagang()
    {
        return $this->belongsTo(DaerahMagangModel::class, 'id_daerah_magang');
    }

    // Relasi ke jenis magang
    public function jenisMagang()
    {
        return $this->belongsTo(JenisMagangModel::class, 'id_jenis_magang');
    }

    // Relasi ke insentif
    public function insentif()
    {
        return $this->belongsTo(InsentifModel::class, 'id_insentif');
    }
}
