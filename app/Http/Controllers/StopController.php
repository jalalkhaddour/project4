<?php

namespace App\Http\Controllers;


use App\Models\Graduation;
use App\Models\Stop;
use App\Models\Student;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Resources\StopResource;
use Nette\Schema\ValidationException;

class StopController extends Controller
{
    public function stop(Request $request)
    {
        try {

            $rules = [
                'university_num' => 'required|numeric',
                'stop_year' => 'required',
                'reason' => 'required',
                'new_university' => 'required',
                'specialization'=>'required'

            ];
            $request->validate($rules);
            //        Params from request
            $university_num = $request->university_num;
            $stop_year = $request->stop_year;
            $reason = $request->reason;
            $new_university = $request->new_university;
            $specialization=$request->specialization;

            $student = Student::query()->where(['university_num'=> $university_num,'specialization'=>$specialization])->first();


            if ($student) {
                $check = Stop::query()->where(
                    'student_id', $student->id
                )->first();

                $check = $check || Transfer::query()->where('student_id', $student->id)->first();
                $check = $check || Graduation::query()->where('student_id', $student->id)->first();

                if (!$check) {

                    $stop = Stop::query()->create([
                        'student_id' => $student->id,
                        'new_university' => $new_university,

                        'stop_year' => $stop_year,
                        'reason' => $reason

                    ]);
                    return StopResource::ok('تم إتمام العملية بنجاح',200);

                } else {
                    return StopResource::returnMsg('لايمكن إتمام العملية .الطالب غير متاح',400,false);
                }

            }

            else {
                return StopResource::returnMsg('لايمكن إتمام العملية .الطالب غير موجود',400,false);

            }
        }

        catch (ValidationException $exv) {
            return StopResource::exception($exv);
        } }

    public function getstopstd(Request $request)
    {
        $student = Stop::query();
//            $studentIds = Stop::query()->pluck('student_id')
//                    -> toArray()
//                ;
//                $student = $student->whereIn('id', $studentIds);
        $student = $student->get();
        return StopResource::collection($student);
    }
}
