<?php

namespace App\Models\Reference;

use App\Models\Reference\PenempatanMagangModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilMagangModel extends Model
{
    use HasFactory;
    
    protected $table = 't_hasil_magang';
    protected $primaryKey = 'id_hasil_magang';

    protected $fillable = [
        'id_penempatan',
        'nama_dokumen',
        'path_dokumen',
        'jenis_dokumen',
        'feedback_magang',
        'tanggal_upload',
    ];

    protected $appends = ['path_dokumen_url'];

    public function getPathDokumenUrlAttribute()
    {
        if (!$this->path_dokumen) return null;
        
        return url('storage/' . $this->path_dokumen);
    }

    public function penempatanMagang(): BelongsTo
    {
        return $this->belongsTo(PenempatanMagangModel::class, 'id_penempatan', 'id_penempatan');
    }
}