<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register extends Model
{
    use HasFactory;
    protected $table = 'registers';
    protected $fillable = ['year','semester','student_id'];
    public function student_register()
    {
        return $this->belongsTo(Student::class,'student_id');

    }
}
