<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    use HasFactory;
    protected $table = 'suspensions';
    protected $fillable = ['suspension_year','suspension_semester','counter','reg_receipt_num','reg_receipt_date','student_id'];
    public function student_suspension()
    {
        return $this->belongsTo(Student::class,'student_id');

    }
}
