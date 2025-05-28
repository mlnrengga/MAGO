<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanMagangModel extends Model
{
    use HasFactory;

    protected $table = 't_pengajuan_magang';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'id_mahasiswa',
        'id_lowongan',
        'tanggal_pengajuan',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(\App\Models\Auth\MahasiswaModel::class, 'id_mahasiswa');
    }

    public function lowongan()
    {
        return $this->belongsTo(LowonganMagangModel::class, 'id_lowongan');
    }
}