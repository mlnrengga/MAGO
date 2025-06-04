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
        'nama',
        'alamat',
        'no_telepon',
        'email',
        'website',
        'partnership',
        'extra_field',
    ];


    public function lowonganMagang(): HasMany
    {
        return $this->hasMany(LowonganMagangModel::class, 'id_perusahaan', 'id_perusahaan');
    }
}
