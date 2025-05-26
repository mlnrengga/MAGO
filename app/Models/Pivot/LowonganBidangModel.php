<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganBidangModel extends Model
{
    protected $table = 'r_lowongan_bidang';
    
    public $timestamps = false;
    
    protected $primaryKey = ['id_lowongan', 'id_bidang'];
    
    public $incrementing = false;
}
