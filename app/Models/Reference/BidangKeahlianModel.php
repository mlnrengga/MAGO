<?php

namespace App\Models\Reference;

use App\Models\Pivot\LowonganBidangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BidangKeahlianModel extends Model
{
    use HasFactory;

    // m_bidang_keahlian
    // + id_bidang_keahlian: int (PK)
    // + nama_bidang_keahlian: String

    protected $table = 'm_bidang_keahlian';
    protected $primaryKey = 'id_bidang';
    protected $fillable = [
        'nama_bidang_keahlian',
    ];

    public function preferensiMahasiswa(): BelongsToMany
    {
        return $this->belongsToMany(
            PreferensiMahasiswaModel::class,
            'r_preferensi_bidang',
            'id_bidang',
            'id_preferensi'
        );
    }
    
    public function lowonganMagang(): BelongsToMany
    {
        return $this->belongsToMany(
            LowonganMagangModel::class,
            'r_lowongan_bidang',
            'id_bidang',
            'id_lowongan'
        );
    }
}