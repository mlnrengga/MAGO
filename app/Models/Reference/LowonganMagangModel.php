<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LowonganMagangModel extends Model
{
    use HasFactory;
    protected $table = 't_lowongan_magang';

    protected $primaryKey = 'id_lowongan';

    protected $fillable = [
        'id_jenis_magang',
        'id_perusahaan',
        'id_daerah_magang',
        'judul_lowongan',
        'deskripsi_lowongan',
        'tanggal_posting',
        'batas_akhir_lamaran',
        'status',
        'id_periode',
        'id_waktu_magang',
        'id_insentif',
    ];

    protected $casts = [
        'tanggal_posting' => 'date',
        'batas_akhir_lamaran' => 'date',
    ];

    public function perusahaan(): BelongsTo
    {
        return $this->belongsTo(PerusahaanModel::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(PeriodeModel::class, 'id_periode', 'id_periode');
    }

    public function bidangKeahlian(): BelongsToMany
    {
        return $this->belongsToMany(
            BidangKeahlianModel::class,
            'r_lowongan_bidang',
            'id_lowongan',
            'id_bidang'
        );
    }

    public function waktuMagang(): BelongsTo
    {
        return $this->belongsTo(WaktuMagangModel::class, 'id_waktu_magang', 'id_waktu_magang');
    }

    public function jenisMagang(): BelongsTo
    {
        return $this->belongsTo(JenisMagangModel::class, 'id_jenis_magang', 'id_jenis_magang');
    }

    public function daerahMagang(): BelongsTo
    {
        return $this->belongsTo(DaerahMagangModel::class, 'id_daerah_magang', 'id_daerah_magang');
    }

    public function insentif(): BelongsTo
    {
        return $this->belongsTo(InsentifModel::class, 'id_insentif', 'id_insentif');
    }

    public function pengajuanMagang()
    {
        return $this->hasMany(PengajuanMagangModel::class, 'id_lowongan', 'id_lowongan');
    }
}
