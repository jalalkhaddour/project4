<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student_courses_state extends Model
{
    use HasFactory;
    protected $table = 'student_courses_state';
    protected $fillable = ['relation_id','state', 'Mark','HaveNow', 'last_exam_date','Examsemster','NumOfFails' ,'study_year', 'issimilar'];
public $timestamps=true;
    public function Relation()
    {
        return $this->belongsTo(student_courses::class);
    }

    public function Student()
    {
        $relate = student_courses::findOrFail(relation_id);
        return $relate->Student();
    }

    public function Course()
    {
        $relate = student_courses::findOrFail(relation_id);
        return $relate->Course();
    }

}
