<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class RoleModel extends SpatieRole
{
    protected $table = 'm_role';
    protected $primaryKey = 'id_role';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;
    
    protected $fillable = [
        'name', // spatie default role_name
        'guard_name', // spatie default guard_name
        'nama_role',
        'kode_role',
    ];    

    use HasFactory;
}
