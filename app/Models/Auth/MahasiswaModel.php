<?php

namespace App\Models\Auth;

use App\Models\UserModel;
use App\Models\Pivot\PreferensiMahasiswaModel;
use App\Models\Reference\PengajuanMagangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    use HasFactory;

    // m mahasiswa
    // + id_mahasiswa: String (PK)
    // + id_user. int (FK)
    // + nim: String
    // + program_studi: String
    // + id_bidang_keahlian: String (FK)
    // + id_lokasi_magang: String (FK)
    // + id_jenis_magang: String (FK)
    // + status_pengajuan_magang: String

    protected $table = 'm_mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $fillable = [
        'id_user',
        'nim',
        'id_prodi',
        'ipk',
        'semester'
    ];
    protected $hidden = [
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user');
    }

    public function preferensi()
    {
        return $this->hasOne(PreferensiMahasiswaModel::class, 'id_mahasiswa');
    }

    public function pengajuanMagang()
    {
        return $this->hasMany(PengajuanMagangModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}
