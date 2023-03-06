<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exam_class;
use App\Models\Student;
use App\Models\Student_in_exam;
use Illuminate\Http\Request;
use League\Config\Exception\ValidationException;

class CheckExamController extends Controller
{
    public function getCheckExAdmin(Request $request)
    {
        try {
            $code = $request->code;
            $specialization = $request->specialization;
            $study_year = $request->studyYear;
            $semster = $request->studysemster;
            $rules = [
                'code' => 'required',
                'specialization' => 'required',
                'studyYear' => 'required',
                'studysemster' => 'required'
            ];
            $messages = [
                'code.required' => 'يجب عليك اختيار المادة',
                'specialization.required' => 'يجب عليك اختيار التخصص',
                'studyYear.required' => 'يجب عليك اختيار العام الدراسي',
                'studysemster.required' => 'يجب عليك اختيار الدورة(أولى - ثانية - ثالثة)'
            ];
            $validated = $request->validate($rules, $messages);
            $course = Course::where(['course_code' => $code, 'specialization' => $specialization, 'IsActive' => 1])->first();
            $Exams = Student_in_exam::where(['course_id' => $course->id, 'study_year' => $study_year, 'semster' => $semster])->get();
            $results = [];
            $count = 0;
            $AttendCount = 0;
            $succCount = 0;
            foreach ($Exams as $exam) {
                $count += 1;
                if ($exam->state)
                    $AttendCount += 1;
                if ($exam->Mark >= 50)
                    $succCount += 1;
                $results [] = $this->ResultFormatter($exam);
            }
            return response()->json(['results' => $results, 'Attend' => $AttendCount, 'recorded' => $count, 'avgOfAttends' => (100 * ($AttendCount / $count)), 'avgOfSuccess' => (100 * ($succCount / $AttendCount))], 200);

        } catch (ValidationException $exc) {
            return response()->json($exc->getMessages(), 400);
        }
    }

    public function AddMarksCheckEx(Request $request)
    {
        try {
            $id = $request->id;
            $Mark = $request->Mark;
            $rules = [
                'id' => 'required',
                'Mark' => 'required|numeric',
            ];
            $messages = [
                'id.required' => 'لم يتم الاختيار بشكل صحيح',
                'Mark.required' => 'يجب عليك إدخال العلامة ',
                'Mark.numeric' => 'يجب أن تكون العلامة قيمة عددية'
            ];
            $validated = $request->validate($rules, $messages);
            $checkSt = Student_in_exam::findOrFail($id);
            if ($checkSt == null)
                return Response()->json(
                    ['message' => 'The given data was invalid.', 'errors' => ['id' => ['هناك خطأ لم يتم العثور على الحقل ']]], 422);
            $checkSt->Mark = $Mark;
            $checkSt->save();
            return response()->json(['تم تعديل العلامة بنجاح'], 200);

        } catch (ValidationException $exc) {
            return response()->json($exc->getMessages(), 400);
        }
    }

    /*
        public function AddCheckEx(Request $request)
        {
            try {
                $course_id = $request->course_id;
                $specialization = $request->specialization;
                $study_year = $request->studyYear;
                $semster = $request->studysemster;
                $student_num = $request->university_num;
                $state = $request->state;
                $classId = $request->class_id;
                $rules = [
                    'course_id' => 'required',
                    'specialization' => 'required',
                    'studyYear' => 'required',
                    'university_num' => 'required',
                    'state' => 'required|boolean',
                    'class_id' => 'required',
                    'studysemster' => 'required'
                ];
                $messages = [
                    'course_id.required' => 'يجب عليك اختيار المادة',
                    'class_id.required' => 'يجب عليك اختيار القاعة الامتحانية',
                    'specialization.required' => 'يجب عليك اختيار التخصص',
                    'studyYear.required' => 'يجب عليك اختيار العام الدراسي',
                    'state.required' => 'يجب عليك اختيار اذا ما كان الطالب حاضرا أولا',
                    'state.boolean' => 'state should be boolean true for Attending ',
                    'university_num.required' => 'يجب عليك إدخال الرقم الجامعي ',
                    'studysemster.required' => 'يجب عليك اختيار الدورة(أولى - ثانية - ثالثة)'
                ];
                $validated = $request->validate($rules, $messages);
                $student = Student::where(['university_num' => $student_num, 'specialization' => $specialization])->first();
                if ($student == null) {
                    $langg = "الانكليزية";
                    if ($specialization == 'fr' || $specialization == 'Fr' || $specialization == 'FR')
                        $langg = "الفرنسية";
                    return Response()->json(
                        ['message' => 'The given data was invalid.', 'errors' => ['university_num' => ["الرقم الجامعي غير موجود في جدول الطلاب قسم اللغة $langg"]]], 422);
                }
                $EXclass = Exam_class::findOrFail($classId);
                $course = Course::findOrFail($course_id);
                if ($EXclass == null)
                    return Response()->json(
                        ['message' => 'The given data was invalid.', 'errors' => ['class' => ['القاعة المحددة خاطئة (غير موجودة) ']]], 422);
                if ($course == null || $course->IsActive == false)
                    return Response()->json(
                        ['message' => 'The given data was invalid.', 'errors' => ['course' => ['المادة المحددة غير متوفرة']]], 422);
                $newExamRecord = Student_in_exam::create([
                    'course_id' => $course_id,
                    'class_id' => $classId,
                    'student_id' => $student->id,
                    'state' => $state,
                    'study_year' => $study_year,
                    'semster' => $semster
                ]);
            } catch (ValidationException $exc) {
                return response()->json($exc->getMessages(), 400);
            }

        }
    */
    public function CheckExState(Request $request)
    {
        $checkId=$request->id;
        $state=$request->state;
        $id = $request->id;
        $Mark = $request->Mark;
        $rules = [
            'id' => 'required',
            'state' => 'required|boolean',
        ];
        $messages = [
            'id.required' => 'لم يتم الاختيار بشكل صحيح',
            'state.required' => 'يجب عليك اختيار الحالة ',
            'state.boolean' => 'يجب أن تكون يكون الحضور قيمة بوليانية للحضور true للغياب false'
        ];
        $validated = $request->validate($rules, $messages);
        $examst=Student_in_exam::findOrFail($checkId);
        if($examst==null){
            return response()->json(['Message'=>'Something went wrong !!!'],800);
        }
        $examst->state=$state;
        $examst->save();
        return response()->json(['Message'=>"تم تعديل الحضور"],200);

    }

    public function PutStudentsInClassByCourse(Request $request)
    {
        try {
            $rules = [
                'course_id' => 'required',
                'specialization' => 'required',
                'studyYear' => 'required',
              //  'class_id' => 'required',
                'studysemster' => 'required'
            ];
            $messages = [
                'course_id.required' => 'يجب عليك اختيار المادة',
                //'class_id.required' => 'يجب عليك اختيار القاعة الامتحانية',
                'specialization.required' => 'يجب عليك اختيار التخصص',
                'studyYear.required' => 'يجب عليك اختيار العام الدراسي',
                'studysemster.required' => 'يجب عليك اختيار الدورة(أولى - ثانية - ثالثة)'
            ];
            $validated = $request->validate($rules, $messages);
            $ExamStudyYear = $request->studyYear;
            $ExamSemster = $request->studysemster;
            $Examdate = $request->ExamDate;
            $course_id = $request->course_id;
            $course = Course::findOrFail($course_id);
            $specialization=$course->specialization;
            $students = student_courses::where(['course_id' => $course_id])->get();
            $validStd = [];
            foreach ($students as $student) {
                $relate = student_courses::where(['course_id' => $course_id, 'student_id' => $student->id])->first();
                $state = $relate->states()->state;
                if ($state->HaveNow) {
                    $validStd[] = $student;
                }
            }

            $vClasses = Exam_class::where(['specialization' => $specialization])->get();
            $validClasses = [];
            foreach ($vClasses as $vClass) {
                if ($vClass->ready > 0)
                    $validClasses[] = $vClass;
            }
            $count = count($validStd) - 1;
            $i = 0;
            foreach ($validClasses as $validClass) {
                for ($i = $i; $i <= $count; $i++) {
                    if ($validClass->ready == 0)
                        break;
                    $student = $validStd[$i];
                    $student->ExamClasses()->attach($validClass->id, ['course_id' => $course_id, 'state' => false, 'Mark' => 0, 'study_year' => $ExamStudyYear, 'semster' => $ExamSemster, 'date' => $Examdate]);
                    $validClass->ready -= 1;
                    $validClass->save();
                    if ($i == $count) {
                        return response()->json(['Message' => "Done"], 200);
                    }
                }
            }
            if ($i <= $count) {
                $b = $i + 1;
                $remain = [];
                $countR = $count - $i;
                for ($i = $i; $i <= $count; $i++) {
                    $remain[] = $validStd[$i];
                }
                return response()->json(['Message' => "لقد قمنا بفرز $b طالب على القاغات لم يعد هناك أمكنة كافية رجاءً أضف قاعات جديدة ", "remaining" => $countR, "studentsRemain" => $remain], 200);
            }


        } catch (ValidationException $exc) {
            return response()->json($exc->getMessages(), 400);
        }
    }

    public function ResultFormatter($request)
    {
        if ($request->state)
            $state = "حضور";
        else
            $state = "غياب";
        $Student_id = $request->student_id;
        $student = Student::findOrFail($Student_id);
        $course = Course::findOrFail($request->course_id);
        $class = Exam_class::findOrFail($request->class_id);
        return [
            'id' => $request->id,
            'student_name' => $student->fullname,
            'university_num' => $student->university_num,
            'course_name' => $course->name,
            'course_code' => $course->course_code,
            'state' => $state,
            'Mark' => $request->Mark,
            'class_num' => $class->class_num,
            'date' => $request->date
        ];

    }
}
