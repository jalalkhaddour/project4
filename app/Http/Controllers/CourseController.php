<?php

namespace App\Http\Controllers;
use App\Models\Register;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\student_courses;
use App\Models\student_courses_state;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function get_all_courses(Request $request )
    {
        $specialization=$request->specialization;
        $courses = Course::where(['IsActive'=> true,'specialization'=>$specialization])->get();
    /*    $results = [];
        foreach ($courses as $course) {
            $results [] = CourseResource::toArray($course);
        }*/

        return CourseResource::collection($courses);

    }

    public function add_course(Request $request)
    {
        try {
            $rules = [
                'course_code' => 'required|numeric',
                'name' => 'required',
                'semester' => 'required',
                'year_of_course' => 'required',
                'specialization' => 'required'

            ];
            $messages = [
                'course_code.required' => 'يجب عليك إدخال كود للمادة',
                'course_code.numeric' => 'يجب أن يكون الكود عدد صحيح',
                'name.required' => 'الرجاء ادخال اسم المادة',
                'semester.required' => 'الرجاء ادخال الفصل الدراسي للمادة',
                'year_of_course.required' => 'الرجاء ادخال السنة الدراسية التي تعطى فيها المادة',
                'specialization.required' => 'الرجاء اختيار تخصص المادة'

            ];

            $request->messages=$messages;
            $request->validate($rules);
//        Params f
//rom request
            $course_code = $request->course_code;
            $specialization = $request->specialization;
            $course = Course::where(['course_code' => $course_code, 'specialization' => $specialization, 'IsActive' => true])->first();
            if ($course==null) {
                    $course = Course::create([
                        'name' => $request->input('name'),
                        'course_code' => $request->course_code,
                        'semester' => $request->input('semester'),
                        'year_of_course' => $request->input('year_of_course'),
                        'specialization' => $request->input('specialization'),
                        'IsActive'=>true
                    ]);

                    return response()->json(['course' => $course, 'message' => 'تمت إضافة المادة بنجاح'], 200);

                } else {
                    return response()->json([
                        'message' => 'المادة موجودة مسبقاً الرجاء إعادة المحاولة'
                    ], 301);
                }
            /*  } else {
                  return response()->json(['message' => 'الرجاء إعادة المحاولة'], 301);
              }*/


        } catch (ValidationException $exv) {
            return response()->json([
                'message' => $exv->getMessage()
            ],400);
        }
    }

    public function updateCourse(Request $request)
    {

        try {
            $rules = [
                'course_code' => 'required',
                'specialization' => 'required'
            ];
            $validator = $request->validate($rules);


            //parms from request
            $course_code = $request->course_code;
            $specialization = $request->specialization;

            $course = Course::query()->where(['course_code ' => $course_code, 'specialization' => $specialization, 'IsActive' => true])->first();

            if ($course) {
                $newname = $request->name;
                if ($newname)
                    $course->name = $newname;

                $newyearofcourse = $request->year_of_course;
                if ($newyearofcourse)
                    $course->year_of_course = $newyearofcourse;

                $newsemester = $request->semester;
                if ($newsemester)
                    $course->semester = $newsemester;


                $course->update();

                return CourseResource::returnMsg('تم تعديل المادة بنجاح', 200, true);
            } else return CourseResource::returnMsg('المادة غير موجودة', 400, false);
        } catch (ValidationException $exv) {
            return CourseResource::exception($exv);

        }
    }

    public function getCourseByCode(Request $request)
    {
        try {
            $rules = [
                'course_code' => 'required',
                'specialization' => 'required'
            ];
            $validator = $request->validate($rules);
            $course_code = $request->course_code;
            $specialization = $request->specialization;

            $course = Course::query()->where(['course_code' => $course_code, 'specialization' => $specialization, 'IsActive' => true])->first();
            return response()->json(['message'=>"success",
                'course'=>$course],200);

        }catch (ValidationException $exv){
            return response()->json(['message'=>"خطأ في إدخال البيانات",
                'error'=>$exv],500);

        }


    }

    public function getCourseBysemster(Request $request)
    {

        $specialization = $request->specialization;
        $year_of_course = $request->year;
        $semster = $request->semester;
        $courses = Course::where([
            'year_of_course' => $year_of_course,
            'specialization' => $specialization,
            'semester' => $semster,
            'IsActive' => true

        ])->get();
        return CourseResource::collection($courses);

    }

    public function showAllCourses(Request $request)
    {
        $specialization = $request->input("specialization");
        $courses = Course::query();
        if ($specialization) {

            $courses = $courses->where(['specialization' => $specialization, 'IsActive' => true])->get();
        }
        return CourseResource::collection($courses);
    }


    public function deleteCourse(Request $request)
    {
        if ($request->id != null) {
            $course = Course::findOrFail($request->id);
        } else {
            $course_code = $request->course_code;
            $specialization = $request->specialization;
            $course = Course::where(['course_code ' => $course_code, 'specialization' => $specialization, 'IsActive' => true])->first();
        }

        $course->IsActive = false;
        $course->update();
        return response()->json(['message' => 'تم شطب المادة ينجاح'], 200);
    }
public function AttatchStudentCourses(Request $request)
{
    $specialization = $request->specialization;
    $university_num = $request->university_num;
    if ($university_num == null)
        return response()->json(['message' => 'The given data was invalid.', 'errors' => ['university_num' => ['يجب عليك إدخال الرقم الجامعي']]], 400);
    if ($specialization == null)
        return response()->json(['message' => 'The given data was invalid.', 'errors' => ['specialization' => ['يجب عليك إدخال التخصص']]], 400);
    $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
    if ($student == null)
        return response()->json(['message' => 'The given data was invalid.', 'errors' => ['university_num' => [' الرقم الجامعي غير موجود في هذا التخصص']]], 400);
    $courses=$request->courses;
    $data=[];
    foreach ($courses as $course){
        $course_id=$course['id'];
        $issimilar=$course['IsSim'];
       $data[]= $this->AttatchStudentCourse($student,$course_id,$issimilar);
    }
    return response()->json($data,200);
}
    public function AttatchStudentCourse(Student $student,$course_id,$issimilar)
    {
        if($student==null){
            return ['course_name'=>'','course_id'=>$course_id,'message' => 'The given data was invalid.', 'errors' => ['university_num' => ['خطأ في جلب الطالب ']],'Code'=>400];

        }
        if ($course_id == null)
            return ['course_name'=>'','course_id'=>$course_id,'message' => 'The given data was invalid.', 'errors' => ['course_id' => ['يجب عليك اختيار المادة']],'Code'=>400];
        $cours = Course::findOrFail($course_id);
        if ($cours == null)
            return ['course_name'=>$cours->name,'course_id'=>$cours->id,'message' => 'The given data was invalid.', 'errors' => ['course_id' => ['الـid غير صحيح تأكد من جلب المواد']],'Code'=>400];


        $relation = student_courses::where(['student_id' => $student->id, 'course_id' => $course_id])->first();
        if ($relation == null)
            $student->Courses()->attach($course_id);

        $relation = student_courses::where(['student_id' => $student->id, 'course_id' => $course_id])->first();
        if ($relation == null)
            return ['course_name'=>$cours->name,'course_id'=>$cours->id,'message' => 'The given data was invalid.', 'errors' => ['حصل خطأ الرجاء المحاولة مجدداً'],'Code'=>400];
        $year=date("Y");
    if(date("F")>=11)
        $year+=1;      
    $prYear=$year-1;
    $study=$year.'-'.$prYear;
    $params=[
        'relation_id' => $relation->id,
        'study_year'=>$study,
        'HaveNow' => true,
        'state' => 'مسجل',
        'Mark' => 0,
        'last_exam_date' => '2000-01-01 19:43:24',
        'issimilar' => $issimilar
    ];
    $stateID = $relation->id;
    $state=student_courses_state::where(['relation_id'=>$relation->id])->first();
    if($state==null){
    $state=student_courses_state::create($params);

        return ['course'=>['course_name'=>$cours->name,'course_id'=>$cours->id],'Message' => 'تم تسجيل المادة بنجاح','Code'=>200];
    }
    elseif ($state->HaveNow) {
        return ['course_name'=>$cours->name,'course_id'=>$cours->id,'message' => 'The given data was invalid.', 'errors' => ['لقد تم تسجيل المادة بالفعل !!'],'Code'=>400];
    }
    else{
        $state->update($params);
        $state->save();
        return ['course'=>['course_name'=>$cours->name,'course_id'=>$cours->id],'Message' => 'تمت إعادة التسجيل على المادة بنجاح','Code'=>200];}
    }

     public function get_availableStudCourses(Request $request)
    {
        
    $specialization = $request->specialization;
    $university_num = $request->university_num;
    if ($university_num == null)
        return response()->json(['message' => 'The given data was invalid.', 'errors' => ['university_num' => ['يجب عليك إدخال الرقم الجامعي']]], 400);
    if ($specialization == null)
        return response()->json(['message' => 'The given data was invalid.', 'errors' => ['specialization' => ['يجب عليك إدخال التخصص']]], 400);
    $student = Student::where(['university_num' => $university_num, 'specialization' => $specialization])->first();
    if ($student == null)
        return response()->json(['message' => 'The given data was invalid.', 'errors' => ['university_num' => [' الرقم الجامعي غير موجود في هذا التخصص']]], 400);
        $years = ['first','second','third','forth'];
        $currentReg = Register::where(['student_id' => $student->id])->orderBy('created_at', 'desc')->first();
        if ($currentReg == null)
            return response()->json(['errors' => ['university_num' => ['لم يقوم الطالب بالتسجيل حتى الآن']]], 400);
        $current_Year = $currentReg->year;
        $notvailCoursesOBJ=[];
        foreach ($years as $year){
       $status=ExamController::getMarksYearStudent($year ,$student);
       $notvailCoursesOBJ[]=$status['notvailCoursesOBJ'];
       if ($current_Year==$year) 
       break;
     }
     return response()->json($notvailCoursesOBJ,200);
    }


}
