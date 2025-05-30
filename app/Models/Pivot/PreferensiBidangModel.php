<?php

namespace App\Models\Pivot;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiBidangModel extends Model
{
    protected $table = 'r_preferensi_bidang';
    
    public $timestamps = true;
    
    protected $primaryKey = ['id_preferensi', 'id_bidang'];
    
    public $incrementing = false;
}
