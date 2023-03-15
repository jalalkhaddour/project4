<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Punishment;
use App\Models\Student;
use Illuminate\Http\Request;
use PHPUnit\Framework\ExpectationFailedException;

class PunishmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPunishments()
    {
        $punishments = Punishment::all();
        $results = [];
        foreach ($punishments as $punishment) {
            $results [] = $this->ResultFormatter($punishment);
        }
        return response()->json($results, 200);
    }

    public function getStudentPunishments(Request $request)
    {
        $specialization = $request->specialization;
        $university_num = $request->university_num;
        $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();

        $punishments = $student->punishments();
        $results = [];
        foreach ($punishments as $punishment) {
            $results [] = $this->ResultFormatter($punishment);
        }
        return response()->json($results, 200);
    }

public function IsOutStudentEx(Request $request){

    $specialization = $request->specialization;
    $university_num = $request->university_num;
    $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
    $punishments = $student->punishments();
    $IsOut=false;
    foreach ($punishments as $punishment){
        if($punishment->IsOut){
            $IsOut=$punishment->IsOut;
            return response()->json([
                'IsOut'=>$punishment->IsOut,
                'Message'=>"الطالب لديه عقوبة استنفاذ سابقة ",
                'punishment_data'=>$punishment
            ],200);}
    }
return response()->json([
    'IsOut'=>$punishment->IsOut,
    "message"=>"الطالب ليس لديه عقوبة استنفاذ"
],200);
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPunishment(Request $request)
    {
        $type = $request->type;
        $reason = $request->reason;
        $seasons_period = $request->seasons_period;
        $specialization = $request->specialization;
        $university_num = $request->university_num;
        $IsOut=$request->IsOut;
        try {
            $rules = [
                'type' => 'required|string',
                'reason' => 'required|string',
                'seasons_period' => 'numeric',
                'specialization' => 'required',
                'university_num' => 'required',
                'IsOut'=>'boolean'
            ];
            $messages = [
                'type.required' => 'يجب عليك تحديد نوع العقوبة إنذار أو حرمان أو استنفاذ',
                'reason.required' => 'يجب عليك كتابة السبب',
                'seasons_period.numeric' => 'يجب أن يكون عدد الحقول عدداً',
                'specialization.required' => 'يجب عليك اختيار الاختصاص ',
                'university_num.required' => 'يجب عليك ادخال الرقم الجامعي للطالب ',
                'IsOut.boolean'=>'يجب عليك تحديد ما اذا كانت العقوبة استنفاذ القيمة بوليانية'
            ];
            $validated = $request->validate($rules, $messages);
            $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
            if ($seasons_period == null) {
                $seasons_period = 0;
            }
            $punishment = Punishment::create([
                'reason' => $reason,
                'type' => $type,
                'seasons_period' => $seasons_period,
                'student_id' => $student->id,
                'IsOut'=>$IsOut
                ]);
            return response()->json([
                'message' => 'success',
                'punishment_data' => $punishment
            ], 200);
        } catch (ValidationException $exc) {
            return response()->json($exc->getMessages(), 400);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updatePunishmet(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        $reason = $request->reason;
        $IsOut=$request->IsOut;
        $seasons_period = $request->seasons_period;

        try {
            $punishment = Punishment::findOrFail($id);
            if ($punishment == null) {
                return response()->json(
                    ['message' => 'The given data was invalid.', 'errors' => ['id' => ['لم يتم العثور على العقوبة المحددة في قاعدة البيانات ']]], 403);
            }
            if ($type != null)
                $punishment->type = $type;
            if ($reason != null)
                $punishment->reason = $reason;
            if ($seasons_period != null)
                $punishment->seasons_period = $seasons_period;
            if ($IsOut != null)
                $punishment->IsOut = $IsOut;
            $punishment->save();
            return response()->json(['message' => 'تم التعديل بنجاح', 'punishment_data'=>punishment], 200);

        } catch (ExpectationFailedException $es) {
            return response()->json($exc->getMessages(), 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deletePunishment(Request $request)
    {
        $id = $request->id;
        $punishment=Punishment::findOrFail($id);
        $punishment->delete();
        return response()->json(['deleted successfuly'],200);

    }

    public function ResultFormatter($request)
    {
        $Student_id = $request->student_id;
        $student = Student::findOrFail($Student_id);
        if($request->IsOut)
            $ISS="العقوبة هي استنفاذ";
        else
            $ISS="العقوبة ليست استنفاذ";

        return [
            'id' => $request->id,
        'student_name' => $student->fullname,
            'university_num' => $student->university_num,
            'reason' => $request->reason,
            'type' => $request->type,
        '$IsOut'=>$ISS,
            'seasons_period' => $request->seasons_period
        ];

    }
}
