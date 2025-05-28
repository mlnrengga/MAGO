<?php

namespace App\Models\Reference;

use App\Models\Auth\MahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenempatanMagangModel extends Model
{
    use HasFactory;

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
}