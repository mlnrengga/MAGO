<?php

namespace App\Models\Reference;

use App\Models\Auth\DosenPembimbingModel;
use App\Models\Pivot\PreferensiMahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JenisMagangModel extends Model
{
    use HasFactory;

    // m_jenis_magang
    // + id_jenis_magang: int (PK)
    // + nama_jenis_magang: String

    protected $table = 'm_jenis_magang';
    protected $primaryKey = 'id_jenis_magang';
    protected $fillable = [
        'nama_jenis_magang',
    ];
    
    public function preferensiMahasiswa()
    {
        return $this->hasMany(PreferensiMahasiswaModel::class, 'id_jenis_magang');
    }

    public function lowonganMagang(): HasOne
    {
        return $this->hasOne(LowonganMagangModel::class, 'id_jenis_magang', 'id_jenis_magang');
    }
}
