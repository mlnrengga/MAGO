<?php

namespace App\Models\Reference;

use App\Models\Pivot\PreferensiMahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangKeahlianModel extends Model
{
    use HasFactory;

    // m_bidang_keahlian
    // + id_bidang_keahlian: int (PK)
    // + nama_bidang_keahlian: String

    protected $table = 'm_bidang_keahlian';
    protected $primaryKey = 'id_bidang_keahlian';
    protected $fillable = [
        'nama_bidang_keahlian',
    ];

    public function preferensiMahasiswa()
    {
        return $this->hasMany(PreferensiMahasiswaModel::class, 'id_bidang_keahlian');
    }
    
}