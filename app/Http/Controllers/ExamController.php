<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\student_courses_state;
use App\Models\Student;
use App\Models\student_courses;
use App\Models\Student_in_exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function getExamByCourse(Request $request)
    {
        $code = $request->code;
        $specialization = $request->specialization;
        $study_year = $request->studyYear;
        $Examsemster = $request->Examsemster;
        $course = Course::where(['course_code' => $code, 'specialization' => $specialization, 'IsActive' => 1])->first();
        $relations = student_courses::where(['course_id' => $course->id])->get();
        $results = [];
        $count = 0;
        $succCount = 0;
        foreach ($relations as $relation) {
            $exam = $relation->state();
            if ($exam->study_year == $study_year and $exam->Examsemster == $Examsemster) {
                $count += 1;
                $mark = $exam->Mark;
                if ($mark >= 50)
                    $succCount += 1;
                $results [] = $this->ResultFormatter($relation);
            }
        }
        $succAvg = 100 * ($succCount / $count);
        return response()->json(['results' => $results, 'avg' => $succAvg, 'RegisterdStd' => $count, 'SuccStd' => $succCount], 200);

    }


    public function getMarksStudent(Request $request)
    {
        $specialization = $request->specialization;
        $university_num = $request->university_num;
        $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
        $results = [];
        $years = ['first','second','third','forth'];
        foreach ($years as $year) {
            $detals=$this->getMarksYearStudent($year, $student);
            $results[] = ['year'=>$year,'detal'=>$detals];
        }

        return response()->json($results, 200);

    }
public function getMarksByYearStudent(Request $request){

    $specialization = $request->specialization;
    $university_num = $request->university_num;
    $reqYear=$request->year;
    $student=Student::where(['university_num'=>$university_num,'specialization'=>$specialization])->first();

    $yearCourses = Course::where([
        'specialization' => $specialization,
        'year_of_course' => $reqYear,
        'IsActive'=>true])->get();
    $yearCoursesCount = $yearCourses->count();
    $studentCouseCount = 0;
    $succCount=0;
    $wholeval = 0;
    $yearsSTD=[];
    foreach ($yearCourses as $yearCourse) {
        $stco = student_courses::where([
            'student_id' => $student->id,
            'course_id' => $yearCourse->id
        ])->first();

        //$vvID= $stco->id;
        if ($stco != null)
            $sateuss = student_courses_state::find($stco->id);

        if ($stco == null) {
            $yearsSTD [] = [
                'id'=>$yearCourse->id,
                'course_name' => $yearCourse->name,
                'course_code' => $yearCourse->course_code,
                'sem'=>$yearCourse->semester,
                'state' => 'غير مسجل',
                'Have'=>false,
                'Mark' => 'غير مسجل',
                'last_exam_date' => 'غير مسجل',
                'issimilar' => false,
                'NumOfFail'=>0,
                'year'=>$reqYear
            ];
        } elseif((!$sateuss->HaveNow)) {

            $vvID= $stco->id;
            $sateuss = student_courses_state::findOrFail($vvID);
            $yearsSTD [] = [
                'id'=>$yearCourse->id,
                'course_name' => $yearCourse->name,
                'course_code' => $yearCourse->course_code,
                'sem'=>$yearCourse->semester,
                'Have'=>$sateuss->HaveNow,
                'state' => $sateuss->state,
                'Mark' => 'غير مسجل',
                'last_exam_date' =>$sateuss->last_exam_date,
                'issimilar' => $sateuss->issimilar,
                'NumOfFail'=>$sateuss->NumOfFails,
                'year'=>$reqYear
            ];
        } else {
            $vvID= $stco->id;
            $sateuss = student_courses_state::findOrFail($vvID);
            $studentCouseCount += 1;
            $yearsSTD [] = [
                'id'=>$yearCourse->id,
                'course_name' => $yearCourse->name,
                'course_code' => $yearCourse->course_code,
                'state' => $sateuss->state,
                'Have'=>$sateuss->HaveNow,
                'Mark' => $sateuss->Mark,
                'last_exam_date' => $sateuss->last_exam_date,
                'issimilar' => $sateuss->issimilar,
                'NumOfFail'=>$sateuss->NumOfFails,
                'sem'=>$yearCourse->semester,
                'year'=>$reqYear
            ];
            if ($sateuss->issimilar) {
                $studentCouseCount -= 1;
                $yearCoursesCount -= 1;
            }
            if ($sateuss->Mark >= 50) {
                $wholeval += $sateuss->Mark;
                $succCount += 1;
            }
        }


    }
    $avg=0;
$def = $yearCoursesCount - $succCount;
if ($yearCoursesCount == $succCount) {
$avg = 100 * ($wholeval / $succCount);
$result = 'نجاح';
} elseif ($def <= 4) {
$result = 'منقول';
}elseif($def >4 and $studentCouseCount==$yearCoursesCount)
            $result='راسب';
else
    $result='مستجد';

return response()->json([
    'cours'=>$yearsSTD,
    'result'=>$result,
    'avg'=>$avg,
    'wholeval'=>$wholeval,
    'year'=>$reqYear

],200);

}

    public static function getMarksYearStudent(string $year, Student $student)
    {
        $yearCourses = Course::where([
            'specialization' => $student->specialization,
            'year_of_course' => $year,
            'IsActive'=>true])->get();
        $yearCoursesCount = $yearCourses->count();
        $studentCouseCount = 0;
        $wholeval = 0;
        $firstsemsterCourses = Course::where([
            'specialization' => $student->specialization,
            'year_of_course' => $year,
            'semester' => 'first',
            'IsActive'=>true
        ])->get();
        $secondsemsterCourses = Course::where([
            'specialization' => $student->specialization,
            'year_of_course' => $year,
            'semester' => 'second',
            'IsActive'=>true
        ])->get();
        $firstcourstate = [];
        $secoundcourstate = [];
        $avg = 0;
        $succCount = 0;
        $result = '';
        $failedCourses=[];
        $notvailCoursesOBJ=[];
        foreach ($firstsemsterCourses as $firstsemsterCours) {
            $stco = student_courses::where([
                'student_id' => $student->id,
                'course_id' => $firstsemsterCours->id
            ])->first();

            //$vvID= $stco->id;
            if ($stco != null)
                $sateuss = student_courses_state::find($stco->id);

            if ($stco == null) {
                $notvailCoursesOBJ[]=[
                    'id' =>'',
                    'course_id'=>$firstsemsterCours->id,
                    'course_name' => $firstsemsterCours->name,
                    'course_code' => $firstsemsterCours->course_code,
                    'year_of_course'=>$firstsemsterCours->year_of_course,
                    'semester'=>$firstsemsterCours->semester,
                    'state' => 'غير مسجل',
                    'Mark' => 'غير مسجل',
                    'last_exam_date' =>'',
                    'issimilar' =>false,
                    'NumOfFail'=>0
                ];
                $firstcourstate [] = ['course_name' => $firstsemsterCours->name, 'course_code' => $firstsemsterCours->course_code, 'state' => 'غير مسجل', 'Mark' => 'غير مسجل', 'last_exam_date' => 'غير مسجل', 'issimilar' => false,'NumOfFail'=>0];
            } elseif(($sateuss != null) and (!$sateuss->HaveNow)) {
                $notvailCoursesOBJ[]=[
                    'id' => $stco->id,
                    'course_id'=>$firstsemsterCours->id,
                    'course_name' => $firstsemsterCours->name,
                    'course_code' => $firstsemsterCours->course_code,
                    'year_of_course'=>$firstsemsterCours->year_of_course,
                    'semester'=>$firstsemsterCours->semester,
                    'state' => $sateuss->state,
                    'Mark' => 'غير مسجل',
                    'last_exam_date' =>$sateuss->last_exam_date,
                    'issimilar' => $sateuss->issimilar,
                    'NumOfFail'=>$sateuss->NumOfFails
                ];
                $firstcourstate [] = ['id'=>$firstsemsterCours->id,
                    'course_name' => $firstsemsterCours->name,
                    'course_code' => $firstsemsterCours->course_code,
                    'state' => $sateuss->state,
                    'Mark' => 'غير مسجل',
                    'last_exam_date' =>$sateuss->last_exam_date,
                    'issimilar' => $sateuss->issimilar,
                    'NumOfFail'=>$sateuss->NumOfFails];
            } else {
                $vvID= $stco->id;

                $sateuss = student_courses_state::findOrFail($vvID);
                $studentCouseCount += 1;
                $firstcourstate [] = [
                    'id' => $stco->id,
                    'course_id'=>$firstsemsterCours->id,
                    'course_name' => $firstsemsterCours->name,
                    'course_code' => $firstsemsterCours->course_code,
                    'state' => $sateuss->state,
                    'Mark' => $sateuss->Mark,
                    'last_exam_date' => $sateuss->last_exam_date,
                    'issimilar' => $sateuss->issimilar,
                    'NumOfFail'=>$sateuss->NumOfFails,
                    'year_of_course'=>$firstsemsterCours->year_of_course,
                    'semester'=>$firstsemsterCours->semester
                ];
                if ($sateuss->issimilar) {
                    $studentCouseCount -= 1;
                    $yearCoursesCount -= 1;
                }
                if ($sateuss->Mark >= 50) {
                    $wholeval += $sateuss->Mark;
                    $succCount += 1;
                }
            }
        }

        foreach ($secondsemsterCourses as $secondsemsterCours) {
            $stco = student_courses::where([
                'student_id' => $student->id,
                'course_id' => $secondsemsterCours->id
            ])->first();
            if ($stco != null)
                $sateuss = student_courses_state::find($stco->id);

            if ($stco == null) {
                $notvailCoursesOBJ[]=[
                    'id'=>'',
                    'course_id'=>$secondsemsterCours->id,
                    'course_name' => $secondsemsterCours->name,
                    'course_code' => $secondsemsterCours->course_code,
                    'year_of_course'=>$secondsemsterCours->year_of_course,
                    'semester'=>$secondsemsterCours->semester,
                    'state' => 'غير مسجل',
                    'Mark' => 'غير مسجل',
                    'last_exam_date' =>'',
                    'issimilar' =>false,
                    'NumOfFail'=>0];
                $secoundcourstate [] = [
                    'course_name' => $secondsemsterCours->name,
                    'course_code' => $secondsemsterCours->course_code,
                    'state' => 'غير مسجل',
                    'Mark' => 'غير مسجل',
                    'last_exam_date' => 'غير مسجل',
                    'issimilar' => false,
                    'NumOfFail'=>0];
            } elseif(($sateuss != null) and (!$sateuss->HaveNow)) {
                $notvailCoursesOBJ[]=[
                    'id'=>$stco->id,
                    'course_id'=>$secondsemsterCours->id,
                    'course_name' => $secondsemsterCours->name,
                    'course_code' => $secondsemsterCours->course_code,
                    'year_of_course'=>$secondsemsterCours->year_of_course,
                    'semester'=>$secondsemsterCours->semester,
                    'state' => $sateuss->state,
                    'Mark' => 'غير مسجل',
                    'last_exam_date' =>$sateuss->last_exam_date,
                    'issimilar' => $sateuss->issimilar,
                    'NumOfFail'=>$sateuss->NumOfFails];
                $secoundcourstate [] = [
                    'course_name' => $secondsemsterCours->name,
                    'course_code' => $secondsemsterCours->course_code,
                    'state' => $sateuss->state,
                    'Mark' => 'غير مسجل',
                    'last_exam_date' =>$sateuss->last_exam_date,
                    'issimilar' => $sateuss->issimilar,
                    'NumOfFail'=>$sateuss->NumOfFails];
            }else{

                $studentCouseCount += 1;
                $secoundcourstate [] = [
                    'course_name' => $secondsemsterCours->name,
                    'course_code' => $secondsemsterCours->course_code,
                    'state' => $sateuss->state,
                    'Mark' => $sateuss->Mark,
                    'last_exam_date' => $sateuss->last_exam_date,
                    'issimilar' => $sateuss->issimilar,
                    'NumOfFail'=>$sateuss->NumOfFails,
                    'year_of_course'=>$secondsemsterCours->year_of_course,
                    'semester'=>$secondsemsterCours->semester
                ];
                if ($sateuss->issimilar) {
                    $studentCouseCount -= 1;
                    $yearCoursesCount -= 1;
                }
                if ($sateuss->Mark >= 50) {
                    $wholeval += $sateuss->state()->Mark;
                    $succCount += 1;
                }
            }
        }
        $def = $yearCoursesCount - $succCount;
        if ($yearCoursesCount == $succCount) {
            $avg = 100 * ($wholeval / $succCount);
            $result = 'نجاح';
        } elseif ($def <= 4) {
            $result = 'منقول';
        }elseif($def >4 and $studentCouseCount==$yearCoursesCount)
            $result='راسب';
        return [
            'first_semster' => $firstcourstate,
            'second_semster' => $secoundcourstate,
            'wholeval' => $wholeval,
            'Avg' => $avg,
            'Year_Courses_Count'=>$yearCoursesCount,
            'success_courses'=>$succCount,
            'failedCourse'=>$failedCourses,
            'notvailCoursesOBJ'=>$notvailCoursesOBJ,
            'result' => $result
        ];
    }

    public function transferCheckExAdmin(Request $request)
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

            foreach ($Exams as $exam) {
                $Student_id = $exam->student_id;
                $courseId = $course->id;
                $relation = student_courses::where(['student_id' => $Student_id, 'course_id' => $courseId])->first();
                $state = $relation->state();
                $state->study_year = $exam->study_year;
                $state->Mark = $exam->Mark;
                $state->last_exam_date=$exam->date;
                $state->Examsemster = $exam->semster;
                if ($exam->state) {
                    if ($exam->Mark >= 50) {
                        $state->state = 'ناجح';
                    } else {
                        $state->state = 'راسب';
                        $state->NumOfFails+=1;
                        $state->HaveNow=false;
                    }
                } else {
                    $state->state = 'غياب';
                    $state->NumOfFails+=1;
                    $state->HaveNow=false;
                }
                $state->save();
            }
            return response()->json(['message' => 'تم ترحيل جلسة الرصد'], 200);

    } catch (ValidationException $exc) {
            return response()->json($exc->getMessages(), 400);
        }

    }

    public function StudentCourses(Request $request){
        $specialization = $request->specialization;
        $university_num = $request->university_num;
        $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
        $results = [];
        $stcours=$student->Courses();
        foreach ($stcours as $stcour){
            $course_id=$stcour->id;
            $relate=student_courses::where(['course_id'=>$course_id,'student_id'=>$student->id])->first();
            $results[]=$this->ResultFormatter($relate);
        }
        return response()->json(['Message'=>'Success','result'=>$results],200);
    }

    public function ResultFormatter($request)
    {
        $Student_id = $request->student_id;
        $student = Student::findOrFail($Student_id);
        $course = Course::findOrFail($request->course_id);
        $state=$request->state();
        return [
            'id' => $state->id,
        'student_name' => $student->fullname,
            'university_num' => $student->university_num,
            'course_name' => $course->name,
            'course_code' => $course->course_code,
            'state' => $state->state,
            'Mark' => $state->Mark,
            'last_exam_date' => $state->last_exam_date,
        'NumOfFails'=>$state->NumOfFails,
        'HaveNow'=>$state->HaveNow,
            'issimilar' => $state->issimilar
        ];

    }

}
