<?php

namespace App\Models\Reference;

use App\Models\Auth\MahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdiModel extends Model
{
    use HasFactory;

    protected $table = 'm_prodi';
    protected $primaryKey = 'id_prodi';

    protected $fillable = [
        'nama_prodi',
        'kode_prodi',
    ];

    public $timestamps = true;

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaModel::class, 'id_prodi', 'id_prodi');
    }
}
