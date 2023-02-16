<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $table = 'transfers';
    protected $fillable = ['new_university','student_id'];

    public function student_transfer()
    {
        return $this->belongsTo(Student::class,'student_id');

    }
}
