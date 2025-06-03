<?php

namespace App\Models\Auth;

use App\Models\MBidangKeahlian;
use App\Models\Pivot\DospemBidangModel;
use App\Models\Reference\BidangKeahlianModel;
use App\Models\Reference\BimbinganModel;
use App\Models\UserModel;
use App\Models\Reference\JenisMagangModel;
use App\Models\Reference\LokasiMagangModel;
use App\Models\Reference\PenempatanMagangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DosenPembimbingModel extends Model
{
    use HasFactory;

    // m_dosen_pembimbing
    // + id_dosen: String (PK)
    // + id_user: int (FK)
    // + nip: String
    // + id_lokasi_magang, int (FK)
    // + id_jenis_magang: int (FK)

    protected $table = 'm_dospem';
    protected $primaryKey = 'id_dospem';
    protected $fillable = [
        'id_user',
        'nip',
    ];
    protected $hidden = [
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user');
    }

    public function bidangKeahlian(): BelongsToMany
    {
        return $this->belongsToMany(
            BidangKeahlianModel::class,
            'r_dospem_bidang_keahlian',
            'id_dospem',
            'id_bidang'
        );
    }

    public function mahasiswaBimbingan(): BelongsToMany
    {
        return $this->belongsToMany(
            PenempatanMagangModel::class,
            'r_bimbingan',
            'id_dospem',
            'id_penempatan'
        );
    }
    // public function bimbingan()
    // {
    //     return $this->hasMany(BimbinganModel::class, 'id_dospem');
    // }
}
