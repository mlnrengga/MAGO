<?php

namespace App\Models;

use App\Models\Auth\DosenPembimbingModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MBidangKeahlian extends Model
{
    use HasFactory;

    protected $table = 'm_bidang_keahlian'; // Pastikan ini menunjuk ke tabel m_bidang_keahlian
    protected $primaryKey = 'id_bidang'; // Tentukan primary key

    protected $fillable = [
        'nama_bidang_keahlian',
    ];

    // Relasi many-to-many ke DosenPembimbingModel
    public function dosenPembimbing()
    {
        return $this->belongsToMany(DosenPembimbingModel::class, 'r_dospem_bidang_keahlian', 'id_bidang', 'id_dospem');
    }
}