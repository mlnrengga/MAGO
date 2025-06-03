<?php

namespace App\Models\Reference;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reference\PenempatanMagangModel;

class LogMagangModel extends Model
{
    protected $table = 't_log_magang';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_penempatan',
        'tanggal_log',
        'keterangan',
        'file_bukti',
        'status',
        'feedback_progres',
    ];

    /**
     * Relasi ke penempatan magang.
     */
    public function penempatan()
    {
        return $this->belongsTo(PenempatanMagangModel::class, 'id_penempatan');
    }
}
