<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPembimbingModel extends Model
{
    use HasFactory;

    // m_dosen_pembimbing
    // + id_dosen: String (PK)
    // + id_user: int (FK)
    // + nip: String
    // + id_lokasi_magang, int (FK)
    // + id_jenis_magang: int (FK)

    protected $table = 'm_dosen_pembimbing';
    protected $primaryKey = 'id_dosen';
    protected $fillable = [
        'id_user',
        'nip',
        'id_lokasi_magang',
        'id_jenis_magang',
    ];
    protected $hidden = [
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user');
    }

    public function lokasiMagang()
    {
        return $this->belongsTo(LokasiMagangModel::class, 'id_lokasi_magang');
    }

    public function jenisMagang()
    {
        return $this->belongsTo(JenisMagangModel::class, 'id_jenis_magang');
    }


}
