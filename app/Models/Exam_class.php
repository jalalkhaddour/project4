<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam_class extends Model
{
    use HasFactory;
    protected $table='exam_classes';
    protected $fillable=[
        'class_num','location','capacity','ready'
    ];

    public function Courses(){
        return $this->belongsToMany(Course::class,'student_in_exams','class_id','course_id')->withPivot('semster','date','state','study_year','Mark');
    }
    public function students(){
        return $this->belongsToMany(Course::class,'student_in_exams','class_id','student_id')->withPivot('semster','date','state','study_year','Mark');
    }
public function Exams(){
        return $this->hasMany(Student_in_exam::class,'class_id');
}

}
