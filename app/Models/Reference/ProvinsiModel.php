<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProvinsiModel extends Model
{
    use HasFactory;

    protected $table = 'm_provinsi';
    protected $primaryKey = 'id_provinsi';
    protected $fillable = [
        'nama_provinsi',
    ];

    public function daerah(): HasMany
    {
        return $this->hasMany(DaerahMagangModel::class, 'id_provinsi', 'id_provinsi');
    }
}
