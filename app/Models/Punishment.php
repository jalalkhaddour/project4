<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Punishment extends Model
{
    use HasFactory;
    protected $table='punishments';
    protected $fillable=[
        'reason','type','seasons_period','IsOut','student_id'
    ];

    public function Student(){
        return $this->belongsTo(Student::class);
    }

}
