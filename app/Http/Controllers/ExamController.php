<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Models\Course;
use App\Models\student_courses_state;
use App\Models\Student;
use App\Models\student_courses;
use App\Models\Student_in_exam;
use Illuminate\Http\Request;
use function Sodium\add;

class ExamController extends Controller
{
        public function getExamByCourse(Request $request)
        {
            $code = $request->code;
            $specialization = $request->specialization;
            $study_year = $request->study_year;
            $Examsemster = $request->Examsemster;
            $course = Course::where(['course_code' => $code, 'specialization' => $specialization, 'IsActive' => 1])->first();
            $relations = student_courses::where(['course_id' => $course->id])->get();
            $results = [];
            $count = 0;
            $succCount = 0;
            foreach ($relations as $relation1) {
                $examID = $relation1->id;
                // $exam = $relation1->states;
                $exam = student_courses_state::find($examID);
                if ($exam == null)
                    return response()->json(['not-found'], 500);
                if ($exam->study_year == $study_year and $exam->Examsemster == $Examsemster) {
                    $count += 1;
                    $ssss = $exam->study_year;

                    $mark = $exam->Mark;
                    if ($mark >= 50)
                        $succCount += 1;
                    $results [] = $this->ResultFormatter($relation1);
                }
            }
            if ($count == 0) {
                // return response()->json(['message' => 'لا يوجد متقدمين'],200);
                $succAvg = -1;
            } else {
                $succAvg = 100 * ($succCount / $count);
            }
            $lololo=BaseResource::paginable($results);
            $behe=$lololo->original;
            $behere=$behe['data'];
            $newdt=['study'=>$study_year,'Examsemster'=>$Examsemster,'spec'=>$specialization,'code'=>$code,'results'=>$behere,'avg'=>$succAvg,'RegisterdStd' =>$count,'SuccStd'=>$succCount];
            return response()->json($newdt,200);

        }
        public function getStudyYearsList()
        {
            $now = new \DateTime('now');
            $month = $now->format('m');//03
            $year = $now->format('Y');//2023
            $lst = (int)$year;
            if ($month >= 10) {
                $lst = (int)$year + 1;
            }
            $years = [];


            while ($lst != 2013) {
                $j = $lst - 1;
                $tem6p = $lst . "/" . $j;
                $years[] = $tem6p;
                $lst -= 1;

            }


            return response()->json([
                'years' => $years,
                'lst' => $lst,
                'tem6p' => $tem6p
            ], 200);
        }

        public function getMarksStudent(Request $request)
        {
            $specialization = $request->specialization;
            $university_num = $request->university_num;
            $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
            $results = [];
            $years = ['first', 'second', 'third', 'forth'];
            foreach ($years as $year) {
                $detals = $this->getMarksYearStudent($year, $student);
                $results[] = ['year' => $year, 'detal' => $detals];
            }

            return response()->json($results, 200);

        }

    public function getMarksYearStudent(string $year, Student $student)
    {
        $yearCourses = Course::where(['specialization' => $student->specialization, 'year_of_course' => $year,'IsActive'=>true])->get();
        $yearCoursesCount = $yearCourses->count();
        $studentCouseCount = 0;
        $wholeval = 0;
        $firstsemsterCourses = Course::where(['specialization' => $student->specialization, 'year_of_course' => $year, 'semester' => 'first','IsActive'=>true])->get();
        $secondsemsterCourses = Course::where(['specialization' => $student->specialization, 'year_of_course' => $year, 'semester' => 'second','IsActive'=>true ])->get();
        $firstcourstate = [];
        $secoundcourstate = [];
        $avg = 0;
        $succCount = 0;
        $result = '';
        $failedCourses=[];
        foreach ($firstsemsterCourses as $firstsemsterCours) {
            $stco = student_courses::where(['student_id' => $student->id, 'course_id' => $firstsemsterCours->id])->first();
            if ($stco == null) {
                $firstcourstate [] = [
                    'id' => 0,
                    'course_name' => $firstsemsterCours->name,
                    'course_code' => $firstsemsterCours->course_code,
                    'state' => 'غير مسجل',
                    'Mark' => '0',
                    'typing'=>"صفر",
                    'last_exam_date' => '',
                    'semester'=>$firstsemsterCours->semester,
                    'issimilar' => false];
            } else {
                $sttt=$stco->states;
                $studentCouseCount += 1;
                $typing=$this->Number2Text($sttt->Mark);
                $firstcourstate [] = [
                    'id' => $stco->id,
                    'course_name' => $firstsemsterCours->name,
                    'semester'=>$firstsemsterCours->semester,
                    'course_code' => $firstsemsterCours->course_code,
                    'state' => $sttt->state,
                    'Mark' => $sttt->Mark,
                    'typing'=>$typing,
                    'last_exam_date' => $sttt->last_exam_date,
                    'issimilar' => $sttt->issimilar
                ];
                if ($sttt->issimilar) {
                    $studentCouseCount -= 1;
                    $yearCoursesCount -= 1;
                }
                if ($sttt->Mark >= 50) {
                    $wholeval += $sttt->Mark;
                    $succCount += 1;
                }else{
                    $failedCourses[]=$firstsemsterCours->name;
                }
            }
        }
        foreach ($secondsemsterCourses as $secondsemsterCours) {
            $stco = student_courses::where(['student_id' => $student->id, 'course_id' => $secondsemsterCours->id])->first();
            if ($stco == null) {
                $typing=$this->Number2Text(0);
                $secoundcourstate [] =
                    ['course_name' => $secondsemsterCours->name,
                        'semester'=>$secondsemsterCours->semester,
                        'course_code' => $secondsemsterCours->course_code,
                        'state' => 'غير مسجل',
                       'Mark' => '0',
                        'typing'=>$typing,
                        'last_exam_date' => 'غير مسجل',
                        'issimilar' => false
                    ];
            } else {
                $sttt=$stco->states;
                $studentCouseCount += 1;
                $typing=$this->Number2Text($sttt->Mark);
                $secoundcourstate [] = [
                    'course_name' => $secondsemsterCours->name,
                    'course_code' => $secondsemsterCours->course_code,
                    'state' => $sttt->state,
                    'Mark' => $sttt->Mark,
                   'typing'=>$typing,
                    'last_exam_date' => $sttt->last_exam_date,
                    'semester'=>$secondsemsterCours->semester,
                    'issimilar' => $sttt->issimilar
                ];
                if ($sttt->issimilar) {
                    $studentCouseCount -= 1;
                    $yearCoursesCount -= 1;
                }
                if ($sttt->Mark >= 50) {
                    $wholeval += $sttt->Mark;
                    $succCount += 1;
                }else{
                    $failedCourses[]=$firstsemsterCours->name;
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
            'result' => $result
        ];
    }
        public function getMarksByYearStudent(Request $request)
        {

            $specialization = $request->specialization;
            $university_num = $request->university_num;
            $reqYear = $request->year;
            $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();

            $yearCourses = Course::where([
                'specialization' => $specialization,
                'year_of_course' => $reqYear,
                'IsActive' => true])->get();
            $yearCoursesCount = $yearCourses->count();
            $studentCouseCount = 0;
            $succCount = 0;
            $wholeval = 0;
            $yearsSTD = [];
            foreach ($yearCourses as $yearCourse) {
                $stco = student_courses::where([
                    'student_id' => $student->id,
                    'course_id' => $yearCourse->id
                ])->first();

                //$vvID= $stco->id;
                if ($stco != null)
                    $sateuss = student_courses_state::find($stco->id);

                if ($stco == null) {

                    $typing=$this->Number2Text(0);
                    $yearsSTD [] = [
                        'id' => $yearCourse->id,
                        'course_name' => $yearCourse->name,
                        'course_code' => $yearCourse->course_code,
                        'sem' => $yearCourse->semester,
                        'state' => 'غير مسجل',
                        'Have' => false,
                        'Mark' => '0',
                        'typing'=>$typing,
                        'last_exam_date' => 'غير مسجل',
                        'issimilar' => false,
                        'NumOfFail' => 0,
                        'year' => $reqYear
                    ];
                } elseif ((!$sateuss->HaveNow)) {

                    $vvID = $stco->id;
                    $sateuss = student_courses_state::findOrFail($vvID);
                    $typing=$this->Number2Text($sateuss->Mark);
                    $yearsSTD [] = [
                        'id' => $yearCourse->id,
                        'course_name' => $yearCourse->name,
                        'course_code' => $yearCourse->course_code,
                        'sem' => $yearCourse->semester,
                        'Have' => $sateuss->HaveNow,
                        'state' => $sateuss->state,
                        'Mark' => $sateuss->Mark,
                        'typing'=>$typing,
                        'last_exam_date' => $sateuss->last_exam_date,
                        'issimilar' => $sateuss->issimilar,
                        'NumOfFail' => $sateuss->NumOfFails,
                        'year' => $reqYear
                    ];
                } else {
                    $vvID = $stco->id;
                    $sateuss = student_courses_state::findOrFail($vvID);
                    $studentCouseCount += 1;
                    $typing=$this->Number2Text($sateuss->Mark);
                    $yearsSTD [] = [
                        'id' => $yearCourse->id,
                        'course_name' => $yearCourse->name,
                        'course_code' => $yearCourse->course_code,
                        'state' => $sateuss->state,
                        'Have' => $sateuss->HaveNow,
                        'Mark' => $sateuss->Mark,
                        'typing'=>$typing,
                        'last_exam_date' => $sateuss->last_exam_date,
                        'issimilar' => $sateuss->issimilar,
                        'NumOfFail' => $sateuss->NumOfFails,
                        'sem' => $yearCourse->semester,
                        'year' => $reqYear
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
            $avg = 0;
            $def = $yearCoursesCount - $succCount;
            if ($yearCoursesCount == $succCount) {
                $avg = 100 * ($wholeval / $succCount);
                $result = 'نجاح';
            } elseif ($def <= 4) {
                $result = 'منقول';
            } elseif ($def > 4 and $studentCouseCount == $yearCoursesCount)
                $result = 'راسب';
            else
                $result = 'مستجد';

            return response()->json([
                'cours' => $yearsSTD,
                'result' => $result,
                'avg' => $avg,
                'wholeval' => $wholeval,
                'year' => $reqYear

            ], 200);

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
                    $state->last_exam_date = $exam->date;
                    $state->Examsemster = $exam->semster;
                    if ($exam->state) {
                        if ($exam->Mark >= 50) {
                            $state->state = 'ناجح';
                        } else {
                            $state->state = 'راسب';
                            $state->NumOfFails += 1;
                            $state->HaveNow = false;
                        }
                    } else {
                        $state->state = 'غياب';
                        $state->NumOfFails += 1;
                        $state->HaveNow = false;
                    }
                    $state->save();
                }
                return response()->json(['message' => 'تم ترحيل جلسة الرصد'], 200);

            } catch (ValidationException $exc) {
                return response()->json($exc->getMessages(), 400);
            }

        }

        public function StudentCourses(Request $request)
        {
            $specialization = $request->specialization;
            $university_num = $request->university_num;
            $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
            $results = [];
            $stcours = $student->Courses();
            foreach ($stcours as $stcour) {
                $course_id = $stcour->id;
                $relate = student_courses::where(['course_id' => $course_id, 'student_id' => $student->id])->first();
                $results[] = $this->ResultFormatter($relate);
            }
            return response()->json(['Message' => 'Success', 'result' => $results], 200);
        }

        public function ResultFormatter($request)
        {
            $Student_id = $request->student_id;
            $student = Student::findOrFail($Student_id);
            $course = Course::findOrFail($request->course_id);
            $state = $request->states;
            return [
                'id' => $state->id,
                'student_name' => $student->fullname,
                'university_num' => $student->university_num,
                'course_name' => $course->name,
                'course_code' => $course->course_code,
                'state' => $state->state,
                'Mark' => $state->Mark,
                'last_exam_date' => $state->last_exam_date,
                'NumOfFails' => $state->NumOfFails,
                'HaveNow' => $state->HaveNow,
                'issimilar' => $state->issimilar
            ];

        }
        function NumberArabic(Request $request){
            return $this->Number2Text($request->Number);
        }
    function Number2Text($numberValue){

        $textResult = '';
        $numberValue = "$numberValue";

        if($numberValue[0] == '-'){
            $textResult .= 'سالب ';
            $numberValue = substr($numberValue,1);
        }

        $numberValue = (int) $numberValue;
        $def = array(    "0" => 'صفر',
            "1" => 'واحد',
            "2" => 'اثنان',
            "3" => 'ثلاث',
            "4" => 'اربع',
            "5" => 'خمس',
            "6" => 'ست',
            "7" => 'سبع',
            "8" => 'ثمان',
            "9" => 'تسع',
            "10" => 'عشر',
            "11" => 'أحد عشر',
            "12" => 'اثنا عشر',
            "100" => 'مائة',
            "200" => 'مئتان',
            "1000" => 'ألف',
            "2000" => 'ألفين',
            "1000000" => 'مليون',
            "2000000" => 'مليونان');

        // check for defind values
        if(isset($def[$numberValue])) {
            // checking for numbers from 2 to 10 :reson = 2 to 10 uses 'ة' at the end
            if($numberValue < 11 && $numberValue > 2){
                if ($numberValue == 8 )
                    $textResult .= $def[$numberValue].'ية';
                else
                    $textResult .= $def[$numberValue].'ة';
            }
            else{
                // the rest of the defined numbers
                $textResult .= $def[$numberValue];
            }
        }
        else{
            $tensCheck = $numberValue%10;
            $numberValue = "$numberValue";

            for($x = strlen($numberValue); $x > 0; $x--){
                $places[$x] = $numberValue[strlen($numberValue)-$x];
            }

            switch(count($places)){
                case 2: // 2 numbers
                case 1: // or 1 number
                    {
                        if ($places[1] == 8 )
                            $textResult .= ($places[1] != 0) ? $def[$places[1]].(($places[1] > 2 || $places[2] == 1) ? 'ية' : '').(($places[2] != 1) ? ' و' : ' ') : '';
                        else

                            $textResult .= ($places[1] != 0) ? $def[$places[1]].(($places[1] > 2 || $places[2] == 1) ? 'ة' : '').(($places[2] != 1) ? ' و' : ' ') : '';
                        $textResult .= (($places[2] > 2) ? $def[$places[2]].'ون' : $def[10].(($places[2] != 2) ? '' : 'ون'));
                    }
                    break;
                case 3: // 3 numbers
                    {
                        $lastTwo = (int) $places[2].$places[1];
                        $textResult .= ($places[3] > 2) ? $def[$places[3]].' '.$def[100] : $def[(int) $places[3]."00"];
                        if($lastTwo != 0){
                            $textResult .= ' و'.Number2Text($lastTwo);
                        }
                    }
                    break;
                case 4: // 4 numbrs
                    {
                        $lastThree = (int) $places[3].$places[2].$places[1];
                        $textResult .= ($places[4] > 2) ? $def[$places[4]].'ة الاف' : $def[(int) $places[4]."000"];
                        if($lastThree != 0){
                            $textResult .= ' و'.Number2Text($lastThree);
                        }
                    }
                    break;
                case 5: // 5 numbers
                    {
                        $lastThree = (int) $places[3].$places[2].$places[1];
                        $textResult .= Number2Text((int) $places[5].$places[4]).((((int) $places[5].$places[4]) != 10) ? ' الفاً' : ' الاف');
                        if($lastThree != 0){
                            $textResult .= ' و'.Number2Text($lastThree);
                        }
                    }
                    break;
                case 6: // 6 numbers
                    {
                        $lastThree = (int) $places[3].$places[2].$places[1];
                        $textResult .= Number2Text((int) $places[6].$places[5].$places[4]).((((int) $places[5].$places[4]) != 10) ? ' الفاً' : ' الاف');
                        if($lastThree != 0){
                            $textResult .= ' و'.Number2Text($lastThree);
                        }
                    }
                    break;
                case 7: // 7 numbers 1 mill
                    {
                        $textResult .= ($places[7] > 2) ? $def[$places[7]].' ملايين' : $def[(int) $places[7]."000000"];
                        $textResult .= ' و';
                        $textResult .= Number2Text((int) $places[6].$places[5].$places[4].$places[3].$places[2].$places[1]);
                    }
                    break;
                case 8: // 8 numbers 10 mill
                case 9: // 9 numbers 100 mill
                    {
                        $places[9] = (isset($places[9])) ? $places[9] : '';
                        $firstThree = (int) $places[9].$places[8].$places[7];
                        $textResult .=     Number2Text($firstThree);
                        $textResult .=    ($firstThree < 11) ? ' ملايين ' : ' مليونا ';
                        if(((int) $places[6].$places[5].$places[4].$places[3].$places[2].$places[1]) != 0){
                            $textResult .= ' و';
                            $textResult .=    Number2Text((int) $places[6].$places[5].$places[4].$places[3].$places[2].$places[1]);
                        }
                    }
                    break;
                default:
                    {
                        $textResult = 'هذا رقم كبير .. ';
                    }
            }

        }
        if($textResult=="مائة")
        {
        return $textResult.' درجة';
        }
        elseif ($textResult=="صفر")
        {
            return $textResult.' فقط';
        }
        else
        {
            return $textResult."  درجة فقط ";
        }
    }

}