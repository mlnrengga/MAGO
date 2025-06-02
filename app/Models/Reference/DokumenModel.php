<?php

namespace App\Models\Reference;

use App\Models\Auth\MahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenModel extends Model
{
    protected $table = 't_dokumen';
    protected $primaryKey = 'id_dokumen';
    public $timestamps = true;

    protected $fillable = [
        'id_mahasiswa',
        'jenis_dokumen',
        'nama_dokumen',
        'path_dokumen',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}
