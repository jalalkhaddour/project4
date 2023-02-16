<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $primaryKey='id';
    protected $fillable = ['course_code','name','year_of_course','semester','specialization','IsActive'];
    public function student(){
        return $this->belongsToMany(Student::class,'student_courses','course_id','student_id');
    }
    public function exams(){
        return $this->belongsToMany(Exam_class::class,'student_in_exams','course_id','class_id')->withPivot('semster','date','state','study_year','Mark');
    }



}
