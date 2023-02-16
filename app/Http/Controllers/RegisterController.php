<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Graduation;
use App\Models\Register;
use App\Models\Stop;
use App\Models\Student;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Resources\RegisterResource;
use Nette\Schema\ValidationException;

class RegisterController extends Controller
{
  public function register(Request $request)
  {
      try {

          $rules = [
              'university_num' => 'required',
              'year' => 'required',
              'semester' => 'required',
              'specialization' => 'required'

          ];
          $request->validate($rules);

          //params from request

          $university_num = $request->university_num;
          $specialization = $request->specialization;
          $semester = $request->semester;
          $year = $request->year;

          $student = Student::query()->where(['university_num' => $university_num, 'specialization' => $specialization])->first();

          if ($student) {
              $check = Transfer::query()->where('student_id',$student->id)->first();
              $check = $check || Stop::query()->where('student_id', $student->id)->first();
              $check = $check || Graduation::query()->where('student_id', $student->id)->first();


              if (!$check) {

                  $register = Register::query()->create([
                      'year' => $year,
                      'semester' => $semester,
                      'student_id' => $student->id
                  ]);
                  return RegisterResource::ok('تم تسجيل الطالب بنجاح', 200);
              } else
                  return RegisterResource::returnMsg('لايمكن إتمام العملية . الطاللب غير متاح', 400, false);
          } else {
              return RegisterResource::returnMsg('لايمكن إتمام العملية . الطاللب غير موجود', 400, false);
          }
      }catch (ValidationException $exv) {

          return RegisterResource::exception($exv);

      }
  }
}
