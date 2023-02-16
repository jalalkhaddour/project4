<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\role;
class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_permissions', 'permissionID', 'userID');
    }

    public function roles()
    {
        return $this->belongsToMany(role::class, 'roles_permissions', 'permissionID', 'roleID');
    }


}
