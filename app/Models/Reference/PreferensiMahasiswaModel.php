<?php

namespace App\Models\Reference;

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
        'id_daerah_magang',
        'ranking_daerah',
        'id_waktu_magang',
        'ranking_waktu_magang',
        'id_insentif',
        'ranking_insentif',
        'ranking_jenis_magang',
        'ranking_bidang'
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa');
    }

    // Relasi ke bidang keahlian
    public function bidangKeahlian(): BelongsToMany
    {
        return $this->belongsToMany(
            BidangKeahlianModel::class,
            'r_preferensi_bidang',
            'id_preferensi',
            'id_bidang',
        )
        ->withTimestamps();
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
        )
        ->withTimestamps();
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
