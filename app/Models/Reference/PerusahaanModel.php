<?php

namespace App\Models\Reference;

use App\Models\Auth\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerusahaanModel extends Model
{
    use HasFactory;

    protected $table = 'm_perusahaan';

    protected $primaryKey = 'id_perusahaan';

    public $incrementing = true;

    protected $fillable = [
        'id_admin',
        'nama',
        'alamat',
        'no_telepon',
        'email',
        'website',
    ];

    public function admin()
    {
        return $this->belongsTo(AdminModel::class, 'id_admin', 'id_admin');
    }

    public function lowonganMagang(): HasMany
    {
        return $this->hasMany(LowonganMagangModel::class, 'id_perusahaan', 'id_perusahaan');
    }
}
