<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;

    protected $table = 'users_permissions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'userID',
    'permissionID'
        ];

}
