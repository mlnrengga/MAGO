<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiJenisModel extends Model
{
    protected $table = 'r_preferensi_jenis_magang';
    
    public $timestamps = true;
    
    protected $primaryKey = ['id_preferensi', 'id_jenis_magang'];
    
    public $incrementing = false;
}
