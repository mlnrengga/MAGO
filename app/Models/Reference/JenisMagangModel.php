<?php

namespace App\Models\Reference;

use App\Models\Auth\DosenPembimbingModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    
    public function preferensiMahasiswa(): BelongsToMany
    {
       return $this->belongsToMany(
            PreferensiMahasiswaModel::class,
            'r_preferensi_jenis_magang',
            'id_jenis_magang',
            'id_preferensi'
        );
    }

    public function lowonganMagang(): HasOne
    {
        return $this->hasOne(LowonganMagangModel::class, 'id_jenis_magang', 'id_jenis_magang');
    }
}
