<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WaktuMagangModel extends Model
{
    use HasFactory;
    protected $table = 'm_waktu_magang';
    protected $primaryKey = 'id_waktu_magang';
    protected $fillable = [
        'nama_waktu_magang',
    ];

    public function lowonganMagang(): HasOne
    {
        return $this->hasOne(LowonganMagangModel::class, 'id_waktu_magang', 'id_waktu_magang');
    }
}
