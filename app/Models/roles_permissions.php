<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class roles_permissions extends Model
{
    use HasFactory;

    protected $table = 'roles_permissions';
    protected $primaryKey = 'id';


    public $incrementing=true;

}
