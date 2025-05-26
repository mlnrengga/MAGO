<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeModel extends Model
{
    use HasFactory;

    protected $table = 'm_periode';

    protected $primaryKey = 'id_periode';
    
    public $incrementing = true;
    
    protected $fillable = [
        'nama_periode'
    ];

    public function lowonganMagang()
    {
        return $this->hasOne(LowonganMagangModel::class, 'id_periode', 'id_periode');
    }
}
