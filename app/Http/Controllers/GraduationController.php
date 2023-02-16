<?php

namespace App\Http\Controllers;

use App\Models\student_courses;
use App\Models\student_courses_state;
use App\Models\Graduation;
use App\Models\Stop;
use App\Models\Student;
use App\Models\Transfer;
use App\Http\Resources\GraduationResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;


class GraduationController extends Controller
{
    public function graduation(Request $request)
    {
        try {

            $rules = [
                'university_num' => 'required',
                'graduation_year' => 'required',
                'graduation_semester' => 'required',
                'specialization' => 'required'

            ];
            $request->validate($rules);
            $university_num = $request->university_num;
            $specialization = $request->specialization;
            $student = Student::query()->where(['university_num' => $university_num, 'specialization' => $specialization])->first();

            if ($student) {

$can =stController::CanGraduate($student);
$check=$can['can'];
                if (!$check) {

                    Graduation::create([
                        'graduation_year' => $request->graduation_year,
                        'graduation_semester' => $request->graduation_semester,
                        'student_id' => $student->id

                    ]);
                    return GraduationResource::returnMsg('تمت العملية بنجاح', 200, true);

                } else {
                    return GraduationResource::returnMsg($can['reason'], 400);
                }
            } else     return GraduationResource::returnMsg('لايمكن إتمام العملية . الطالب غير موجود ', 400);
        } catch (ValidationException $exv) {

            return GraduationResource::exception($exv);

        }
    }

    public function getGraduateStudents(Request $request)
    {

        $specialization = $request->specialization;
        $graduation_year=$request->graduation_year;
        $certifeca = $request->certifeca;
        $graduation_semester=$request->graduation_semester;

        $grads = Graduation::all();
        $students=[];
        foreach ($grads as $grad) {
            $student=Student::where(['id'=>$grad->id])->first();
            if ($student->specialization==$specialization) {
                if(($certifeca==null)and($graduation_year==null)and($graduation_semester==null)){

                    $students=[
                        'fullname'=>$student->fullname,
                        'fathername'=>$student->fathername,
                        'birthdate'=>$student->birthdate,
                        'university_num'=>$student->university_num,
                        'graduation_semester'=>$grad->graduation_semester,
                        'graduation_year'=>$grad->graduation_year
                    ];
                }}

        }



        return response()->json($students,200);

    }

    public function searchForGradStd(Request $request)
    {
        try {

            $rules = [
                'university_num' => 'required',
                'specialization' => 'required'

            ];
            $request->validate($rules);

            //parms from request
            $university_num = $request->university_num;
            $specialization = $request->specialization;
            $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
            if($student) {
                $student_id = $student->id;

                $grad_std = Graduation::where(['student_id'=>$student_id])->first();
                if ($grad_std)
                    return response()->json(
                        [
                            'fullname'=>$student->fullname,
                            'fathername'=>$student->fathername,
                            'birthdate'=>$student->birthdate,
                            'university_num'=>$university_num,
                            'graduation_semester'=>$grad_std->graduation_semester,
                            'graduation_year'=>$grad_std->graduation_year

                        ],200);
                else
                    return GraduationResource::returnMsg('الطالب لم يتخرج بعد', 400);
            }
            else return GraduationResource::returnMsg('الطالب غير موجود',400);

        } catch (ValidationException $exv) {

            return GraduationResource::exception($exv);


        }
    }

}
