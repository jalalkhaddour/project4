<?php

namespace App\Models;

use App\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\forlogging;
use App\Listeners\LockoutListener;
use App\Listeners\LoginListener;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use forlogging;

    protected $table ='users';
    protected $primaryKey ='id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'username',
        'password',
        'remember_token',
        'fname',
        'lname',
        'roleID',
        'IsActive',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>aaaaaa
     */
    public function logs()
    {
        return $this->hasMany(log::class);
    }
    public function Role(){
        return $this->belongsTo(role::class);
    }
    public function Permissions(){
        return $this->belongsToMany(Permission::class,'users_permissions','userID',
            'permissionID');

    }
    public function AllPermissions()
    {
        $Role=role::findOrFail($this->roleID);
        $rolePerms=$Role->Permissions()->get();
        $UserPerms=$this->Permissions()->get();
        $perms=$rolePerms->merge($UserPerms);
        $names=[];
        $v=0;
        foreach ($perms as $perm) {
            $names[$v]=$perm->name;
            $v+=1;
        }

        return $names;

    }


}
