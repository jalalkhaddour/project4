<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public $dates = ['log_date'];
    protected $appends = ['dateHumanize','json_data'];

    private $userInstance = "\App\User";

    public function __construct() {
        $userInstance = User::class;
        if(!empty($userInstance)) $this->userInstance = $userInstance;
    }

    public function getDateHumanizeAttribute()
    {
        return $this->log_date->diffForHumans();
    }

    public function getJsonDataAttribute()
    {
        return json_decode($this->data,true);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
