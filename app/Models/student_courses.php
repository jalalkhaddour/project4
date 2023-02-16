<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_courses extends Model
{
    use HasFactory;
    protected $table='student_courses';

    protected $primaryKey='id';
    public function Student(){
       return $this->belongsTo(Student::class);
    }
    public function Course(){
       return $this->belongsTo(Course::class);
    }
public function states()
{
    return $this->hasOne(student_courses_state::class);
}
public $timestamps=true;
}
