<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;
    protected $table= 'stops';
    protected $fillable = ['stop_year', 'reason', 'new_university','student_id'];

    public function student_stop()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}
