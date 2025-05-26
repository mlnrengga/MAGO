<?php

namespace App\Models\Reference;

use App\Models\Pivot\PreferensiMahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsentifModel extends Model
{
    use HasFactory;

    protected $table = 'm_insentif';
    protected $primaryKey = 'id_insentif';

    public function preferensiMahasiswa()
    {
        return $this->hasMany(PreferensiMahasiswaModel::class, 'id_insentif');
    }
    
}
