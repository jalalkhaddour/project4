<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_in_exam extends Model
{
    use HasFactory;
    protected $table = 'student_in_exams';

    protected $fillable = [
        'state', 'Mark', 'study_year', 'semster', 'date'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function ExamClass()
    {
        return $this->belongsTo(Exam_class::class, 'class_id');
    }

}
