<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\SuspensionResource;
use App\Models\Graduation;
use App\Models\Stop;
use App\Models\Student;
use App\Models\Suspension;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;


class SuspensionController extends Controller
{
    public function suspension(Request $request){

    try{

            $rules = [
                'university_num' => 'required',
                'suspension_year' => 'required',
                'suspension_semester' => 'required',
                'specialization' => 'required',
                'reg_receipt_num' => 'required',
                'reg_receipt_date' => 'required'

            ];
            $request->validate($rules);

            //params from request

            $university_num = $request->university_num;
            $specialization = $request->specialization;


            $student = Student::query()->where(['university_num' => $university_num,
                'specialization' => $specialization
            ])->first();

            if ($student) {

                $check = Transfer::query()->where('student_id',$student->id)->first();
                $check = $check || Stop::query()->where('student_id', $student->id)->first();
                $check = $check || Graduation::query()->where('student_id', $student->id)->first();

                $count=Suspension::query()->where('student_id',$student->id)->latest()->first();
                if ($count)
                    $counter=$count->counter;
                else $counter=0;

        //    dd($counter);
            if (!$check) {


                    if ($counter< 4) {
                        $suspens = Suspension::query()->create([
                            'suspension_year' => $request->suspension_year,
                            'suspension_semester' => $request->suspension_semester,
                            'reg_receipt_num' => $request->reg_receipt_num,
                            'reg_receipt_date' => $request->reg_receipt_date,
                            'student_id' => $student->id,
                            'counter'=> $counter+1
                        ]);

                        return BaseResource::ok('تم تسجيل الطالب بنجاح', 200);
                    }else   return BaseResource::returnMsg('لايمكن إتمام العملية . الطاللب تجاوز الحد المسموح به', 400, false);

                }else
                    return BaseResource::returnMsg('لايمكن إتمام العملية . الطاللب غير متاح', 400, false);
            } else {
                return BaseResource::returnMsg('لايمكن إتمام العملية . الطاللب غير موجود', 400, false);
            }

        }catch (ValidationException $exv) {

            return BaseResource::exception($exv);

        }
    }
    public function getStudentSuspense(Request $request)
    {

        $university_num = $request->university_num;
        $specialization = $request->specialization;

        $student = Student::query()->where(['university_num' => $university_num, 'specialization' => $specialization])->first();
        $student_id=$student->id;


        $susStudent=Suspension::query()->where('student_id',$student_id)->get();

        return SuspensionResource::collection($susStudent);

    }

}

