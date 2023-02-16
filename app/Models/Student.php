<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $primaryKey ='id';

    protected $attributes = [
        'nationality'=>'Syrian',
        'homephone'=>0310000000,
        'certifeca' =>'bac',
        'specialization'=>'en'
    ];

    public function Courses(){
        return $this->belongsToMany(Course::class,'student_courses','student_id','course_id');
    }

    public function ExamClasses(){
        return $this->belongsToMany(Exam_class::class,'student_in_exams','student_id','class_id')->withPivot( 'state', 'Mark', 'study_year', 'semster', 'date');
    }

    public function Stops(){
        return $this->hasMany(Stop::class,'student_id','id');
    }
    public function Suspensions(){
        return $this->hasMany('suspensions','student_id','id');
    }
    public function Graduation(){
        return $this->hasOne('graduations','student_id','id');
    }
    public function Registers(){
        return $this->hasMany('registers','student_id','id');
    }
    public function Transfers(){
        return $this->hasMany('transfers','student_id','id');
    }


    protected $fillable = ['fullname','fathername','mothername','birthplace','birthdate','gender',
        'place_num_registration','nationality','address','phone','recruitment_division',
        'national_num','homephone','university_num','certifeca','specialization'];


    public function transfer()
    {
        return $this->hasMany(Transfer::class);
    }

    public function stop()
    {
        return $this->hasOne(Stop::class);
    }
    public function grad()
    {
        return $this->hasOne(Graduation::class);
    }
    public function register()
    {
        return $this->hasMany(Register::class);
    }
    public function punishments(){
        return $this->hasMany(Punishment::class,'student_id');
    }

}
