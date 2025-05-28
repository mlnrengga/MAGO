<?php

namespace App\Models\Reference;

use App\Models\Auth\MahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'tanggal_diterima',
    ];
    
    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_diterima' => 'date',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function lowongan(): BelongsTo
    {
        return $this->belongsTo(LowonganMagangModel::class, 'id_lowongan', 'id_lowongan');
    }
}
