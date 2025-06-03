<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaerahMagangModel extends Model
{
    use HasFactory;

    protected $table = 'm_daerah_magang';
    protected $primaryKey = 'id_daerah_magang';
    protected $fillable = [
        'nama_daerah',
        'jenis_daerah',
        'id_provinsi',
        'latitude',
        'longitude',
    ];

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(ProvinsiModel::class, 'id_provinsi', 'id_provinsi');
    }

    protected function namaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->nama_daerah}, {$this->jenis_daerah}",
        );
    }

    protected function namaLengkapDenganProvinsi(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->nama_daerah}, {$this->jenis_daerah}, {$this->provinsi->nama_provinsi}",
        );
    }
}
