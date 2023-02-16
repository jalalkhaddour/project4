<?php

namespace App\Http\Controllers;


use App\Models\Graduation;
use App\Models\Stop;
use App\Models\Student;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Http\Resources\TransferResource;
use Nette\Schema\ValidationException;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        try {
            $rules = [
                'university_num' => 'required|numeric',
                'new_university' => 'required',
                'specialization'=>'required'

            ];
            $request->validate($rules);
//        Params from request
           $university_num = $request->university_num;
            $specialization = $request->specialization;

            $student = Student::query()->where(['university_num'=> $university_num,'specialization'=> $specialization])->first();
            if ($student) {
                $check = Transfer::query()->where([
                    'student_id' => $student->id,
                    //'new_university' => $request->new_university
                ])->first();

                $check = $check || Stop::query()->where('student_id', $student->id )->first();
                $check = $check || Graduation::query()->where('student_id', $student->id)->first();

                if (!$check) {

                    $transfer = Transfer::query()->create([
                        'new_university' =>  $request->input('new_university'),
                        'student_id' => $student->id
                    ]);
                    return TransferResource::ok('تم نقل الطالب بنجاح',200);

                }else {
                    return TransferResource::returnMsg('لايمكن إتمام العملية . الطاللب غير متاح',400,false);
                }



            }else {
                return TransferResource::returnMsg('لايمكن إتمام العملية . الطاللب غير موجود',400,false);
            }




        } catch (ValidationException $exv) {

            return TransferResource::exception($exv);

         }


    }
}
