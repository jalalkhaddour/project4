<?php

namespace App\Http\Controllers;

use App\Http\Resources\Exam_classResource;
use App\Models\Course;
use App\Models\Exam_class;
use App\Models\student_courses;
use Illuminate\Http\Request;

class ExamClassController extends Controller
{
    public function addClassEx(Request $request)
    {
        try {
            $rules = [
                'class_num' => 'required',
                'capacity' => 'required',
                'specialization'=>'required'];

            $request->validate($rules);
            $specialization=$request->specialization;
//        Params from request
            $class_num = $request->class_num;

            $Exam_class = Exam_Class::query()->where(['class_num'=>$class_num,'specialization'=>$specialization])->first();
            $check = Exam_class::query()->where([
                'class_num' => $request->class_num,
                'specialization'=>$specialization
            ])->first();
//

            if (!$check) {

                $Exam_class = Exam_class::query()->create([
                    'class_num' => $request->class_num,
                    'capacity' => $request->capacity,
                    'specialization'=>$specialization,
                    'location' => $request->location,
                    'ready' => 0

                ]);

            } else {
                return response()->json([
                    '' => 'please check the class details, the request is already exist'
                ], 301);
            }
        } catch (ValidationException $exv) {
            return response()->json([
                'message' => $exv->getMessage()
            ], 404);
        }
        return response()->json(['message'=>'تمت إضافة القاعة بنجاح','class'=>$Exam_class],200);
    }

    public function showAllClasses(Request $request)
    {
        $specialization=$request->specialization;
        $Exam_classes = Exam_class::where('specialization',$specialization)->get();
        $results = [];
        foreach ($Exam_classes as $exam_class) {
            $results [] = $this->ResultFormatter($exam_class);
        }
        return response()->json(['classes' => $results], 200);
    }

    public function setExamClassReady(Request $request)
    {
        $class_num = $request->class_num;
        try {
            $Exam_class = Exam_Class::query()->where(['class_num'=>$class_num,'specialization'=>$specialization])->first();
            $Exam_class->ready = $request->ready;
            $$Exam_class->update();

            return response()->json(['ExamClass' => $Exam_class], 200);
        } catch (SQLiteException $xx) {
            return response()->json(['message' => $xx], 401);
        }
    }

    public function UpdateExamClass(Request $request)
    {
        try {

            $id = $request->id;
            $Exam_class = Exam_Class::findOrFail($id);
            $newclass_num = $request->class_num;
            $newReady = $request->ready;
            $newlocation = $request->location;
            $newcapacity = $request->capacity;
            if ($newlocation)
                $Exam_class->location = $newlocation;
            if ($newcapacity)
                $Exam_class->capacity = $newcapacity;
            if ($newReady)
                $Exam_class->ready = $newReady;
            if ($newclass_num)
                $Exam_class->class_num = $newclass_num;
            $Exam_class->save();
            return response()->json(['Message'=>'Success','ExamClass'=>$Exam_class],200);

        } catch (SQLiteException $xx) {
            return response()->json(['message' => $xx], 401);
        }

}

    public function DeleteExamClass(Request $request)
    {
        $id=$request->id;
        try {
            $Exam_class = Exam_Class::findOrFail($id);
        }catch (\SQLiteException $err){
            return response()->json(['Message'=>'error while find the class'],403);
        }
        $resu=Exam_class::Destroy($id);
        if($resu!=0){
            return response()->json(['Message'=>'تم حذف القاعة'],200);
        }else{
            return response()->json(['Message'=>'لم يتم حذف القاعة خطأ في الوصول'],400);
        }

}



    public function ResultFormatter($request)
    {

        return [
            'class_id' => $request->id,
            'class_num' => $request->class_num,
            'capacity' => $request->capacity,
            'ready' => $request->ready,
            'specialization'=>$request->specialization,
            'location' => $request->location
        ];
    }
}
