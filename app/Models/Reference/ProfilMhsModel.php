<?php

namespace App\Models\Reference;

use App\Models\Auth\MahasiswaModel;
use App\Models\Pivot\PreferensiBidangModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilMhsModel extends Model
{
    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $fillable = ['id_user', 'nim', 'id_prodi', 'ipk', 'semester', 'pengalaman'];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user', 'id_user');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function prodi()
    {
        return $this->belongsTo(ProdiModel::class, 'id_prodi', 'id_prodi');
    }
}
