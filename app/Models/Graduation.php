<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Graduation extends Model
{
    use HasFactory;

    protected $table='graduations';
    protected $fillable = ['graduation_year','graduation_semester','student_id'];

    public function grad_std(){
        return $this->belongsTo(Student::class);
    }
}
