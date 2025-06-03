<?php

namespace App\Models\Reference;

use App\Models\Auth\DosenPembimbingModel;
use App\Models\Auth\MahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PenempatanMagangModel extends Model
{
    use HasFactory;

    public const STATUS_BERLANGSUNG = 'Berlangsung';
    public const STATUS_SELESAI = 'Selesai';

    protected $table = 't_penempatan_magang';
    protected $primaryKey = 'id_penempatan';

    protected $fillable = [
        'id_mahasiswa',
        'id_pengajuan',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanMagangModel::class, 'id_pengajuan', 'id_pengajuan');
    }

    // Relasi ke bimbingan
    public function dosenPembimbing(): BelongsToMany
    {
        return $this->belongsToMany(
            DosenPembimbingModel::class,
            'r_bimbingan',
            'id_penempatan',
            'id_dospem'
        );
    }
}