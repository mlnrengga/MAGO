<?php

namespace App\Models\Pivot;

use App\Models\Auth\MahasiswaModel;
use App\Models\Reference\BidangKeahlianModel;
use App\Models\Reference\DaerahMagangModel;
use App\Models\Reference\InsentifModel;
use App\Models\Reference\JenisMagangModel;
use App\Models\Reference\WaktuMagangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function bidangMahasiswa(): BelongsToMany
    {
        return $this->belongsToMany(
            BidangKeahlianModel::class,
            'r_preferensi_bidang',
            'id_preferensi',
            'id_bidang',
            'ranking_bidang'
        );
    }

    // Relasi ke daerah magang
    public function daerahMagang()
    {
        return $this->belongsTo(DaerahMagangModel::class, 'id_daerah_magang');
    }

    // Relasi ke jenis magang
    public function jenisMagang(): BelongsToMany
    {
        return $this->belongsToMany(
            JenisMagangModel::class,
            'r_preferensi_jenis_magang',
            'id_preferensi',
            'id_jenis_magang',
            'ranking_jenis_magang'
        );
    }

    // Relasi ke insentif
    public function insentif()
    {
        return $this->belongsTo(InsentifModel::class, 'id_insentif');
    }

    // Relasi ke waktu magang
    public function waktuMagang()
    {
        return $this->belongsTo(WaktuMagangModel::class, 'id_waktu_magang');
    }
}
