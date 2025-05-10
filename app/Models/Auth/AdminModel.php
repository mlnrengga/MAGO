<?php

namespace App\Models\Auth;

use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    use HasFactory;

    // m_admin
    // + id_admin: String (PK)
    // + id_user: int (FK)
    // + nip: String

    protected $table = 'm_admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = [
        'id_user',
        'nip',
    ];
    protected $hidden = [
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'id_user');
    }

}
