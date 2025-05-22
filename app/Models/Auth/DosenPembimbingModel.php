<?php

namespace App\Models\Auth;

use App\Models\UserModel;
use App\Models\Reference\JenisMagangModel;
use App\Models\Reference\LokasiMagangModel;
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

    protected $table = 'm_dospem';
    protected $primaryKey = 'id_dosen';
    protected $fillable = [
        'id_user',
        'nip',
    ];
    protected $hidden = [
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user');
    }
}
