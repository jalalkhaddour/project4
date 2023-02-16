<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Register;
use App\Models\Stop;
use App\Models\Student;
use App\Models\Transfer;
use Illuminate\Http\Request;

class stController extends Controller
{
    public static function getStudentSituation(Request $request)
    {


        $specialization = $request->specialization;
        $university_num = $request->university_num;
        if ($university_num == null)
            return response()->json(['errors' => ['university_num' => ['يجب عليك إدخال الرقم الجامعي']]], 400);
        if ($specialization == null)
            return response()->json(['errors' => ['specialization' => ['يجب عليك إدخال التخصص']]], 400);
        $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
        if ($student == null)
            return response()->json(['errors' => ['university_num' => [' الرقم الجامعي غير موجود في هذا التخصص']]], 400);
        $currentReg = Register::where(['student_id' => $student->id])->orderBy('created_at', 'desc')->first();
        if ($currentReg == null)
            return response()->json(['errors' => ['university_num' => ['لم يقوم الطالب بالتسجيل حتى الآن']]], 400);
        $currentYear = $currentReg->year;
        $currSemster = $currentReg->semester;
        $years = ['first', 'second', 'third', 'forth'];
        $failedcourses = [];
        $result = 'مستجد';

        foreach ($years as $year) {
            if ($year == $currentYear)
                break;
            $values = ExamController::getMarksYearStudent($year, $student);
            $result = $values['result'];
            $failedcourses[] = $values['failedCourse'];
            $notvailCoursesOBJ=$values['notvailCoursesOBJ'];
        }
        $values2 = ExamController::getMarksYearStudent($currentYear, $student);
        if ($values2 != null)
            $failedcourses[] = $values2['failedCourse'];
        $notvailCoursesOBJ=$values2['notvailCoursesOBJ'];
        $currResult = $values2['result'];
        if ($currResult == 'راسب') {
            $result = $currResult;
        }

        return response()->json(['current_Year' => $currentYear,
            'current_Semster' => $currSemster,
            'lastResult' => $result,
            'CurrResult' => $currResult,
            'failedCourses' =>$failedcourses
        ], 200);
    }

    public function CanGraduate(Student $student)
    {   $specialization = $request->specialization;
        $university_num = $request->university_num;
        $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
        if ($student == null)
            return ['can'=>false,'reasons' =>'الطالب غير موجود !' ];
        $currentReg = Register::where(['student_id' => $student->id])->orderBy('created_at', 'desc')->first();
        $transfers=Transfer::where(['student_id'=>$student->id])->first();
        if($transfers!=null)
            return ['can'=>false,'reasons' =>'لقد تم نقل الطالب سابقاً خارج الجامعة !' ];
        $stops=Stop::where(['student_id'=>$student->id])->first();
        if($stops!=null)
            return ['can'=>false,'reasons' =>'لقد قام الطالب بترقين القيد !' ];
        if ($currentReg == null)
            return ['can'=>false,'reasons' =>'لم يقوم الطالب بالتسجيل بعد !' ];
        $currentYear = $currentReg->year;
        $currSemster = $currentReg->semester;
        if ($currentYear == 'forth') {
            $years = ['first', 'second', 'third', 'forth'];
            $failedCourses = [];
            $failItrator = [];
            $allcoursesCount = 0;
            $success_courses = 0;
            $avg = 0.0;
            foreach ($years as $year) {
                $values = ExamController::getMarksYearStudent($year, $student);
                $allcoursesCount += $values['Year_Courses_Count'];
                $success_courses += $values['success_courses'];
                $failItrator = $values['failedCourse'];
                if (count($failItrator) == 0) {
                } else {
                    foreach ($failItrator as $fail) {
                        $failedCourses[] = $fail;
                    }
                }
            }
            if (count($failedCourses) == 0 and $success_courses == $allcoursesCount)
                return ['can'=>true,'reasons' =>'بإمكان الطالب التخرج !' ];
        }
            return ['can'=>false,'reasons' =>'الطالب ليس من طلاب السنة الأخيرة !' ];


    }

    public function AvgForGradStud(Request $request)
    {
        $specialization = $request->specialization;
        $university_num = $request->university_num;
        if ($university_num == null)
            return response()->json(['errors' => ['university_num' => ['يجب عليك إدخال الرقم الجامعي']]], 400);
        if ($specialization == null)
            return response()->json(['errors' => ['specialization' => ['يجب عليك إدخال التخصص']]], 400);
        $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
        if ($student == null)
            return response()->json(['errors' => ['university_num' => [' الرقم الجامعي غير موجود في هذا التخصص']]], 400);
        $years = ['first', 'second', 'third', 'forth'];
        $wholeval = 0;
        $allcoursesCount = 0;
        $success_courses = 0;
        $avg = 0.0;
        foreach ($years as $year) {
            $values = ExamController::getMarksYearStudent($year, $student);
            $wholeval += $values['wholeval'];
            $allcoursesCount += $values['Year_Courses_Count'];
            $success_courses += $values['success_courses'];
        }
        if ($success_courses == $allcoursesCount)
            $avg = ($wholeval / $success_courses);
        else
            return response()->json(['Errors' => 'حصل خطأ ما الطالب ليس ناجح في جميع المواد'], 200);
        return response()->json([
            'allStdCourses' => $success_courses,
            'GradAvg' => $avg
        ], 200);

    }

    public function GetLastUnvBySpec(Request $request)
    {

        $specialization = $request->specialization;
        $student = Student::where(['specialization' => $specialization])->orderBy('university_num', 'desc')->first();
        $lastNum = $student->university_num + 1;
        return response()->json(['lastNum' => $lastNum], 200);
    }
}
