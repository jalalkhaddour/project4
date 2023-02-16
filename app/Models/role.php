<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;

class role extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',

    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions', 'roleID', 'permissionID')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'roleID');
    }

    public static function getRoleID(String $rolename)
    {
        return role::where('name', $rolename)->first()->getKey();
    }

    public function getID()
    {
        return $this->id;
    }
}

