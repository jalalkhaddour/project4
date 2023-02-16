<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SimilarCoursesResource;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\SimilarCourses;
use Nette\Schema\ValidationException;

class SimilarCoursesController extends Controller
{
    public function similer_course(Request $request)
    {
        try {

            $rules = [
                'course_code' => 'required',
                'year' => 'required',
                'certifeca' => 'required'
            ];
            $request->validate($rules);
            //        Params from request
            $course_code = $request->course_code;
            $year = $request->year;
            $certifeca = $request->certifeca;


            $course = Course::query()->where(['course_code' => $course_code])->first();

            if ($course) {
                $course_id = $course->id;


                $sim_course = SimilarCourses::query()->create([
                    'course_id' => $course_id,
                    'year' => $year,
                    'certifeca' => $certifeca

                ]);
                return SimilarCoursesResource::ok('تم إتمام العملية بنجاح', 200);

            } else {
                return SimilarCoursesResource::returnMsg('لايمكن إتمام العملية .المادة غير موجودة', 400, false);
            }

        }catch (ValidationException $exv) {
            return SimilarCoursesResource::exception($exv);
        } }

        public function get_sim_course(Request $request){
            try {

            $rules = [
                'university_num' => 'required',
                'specialization' => 'required',


            ];
            $request->validate($rules);
            //        Params from request
            $course_code = $request->course_code;
            $university_num = $request->university_num;
            $specialization = $request->specialization;
            $year = $request->year;



            $student = Student::query()->where(['university_num' => $university_num, 'specialization' => $specialization])->first();
            if ($student) {
                $student_id = $student->id;
                $certifeca = $student->certifeca;

//                if ($year)
//            $stsico=SimilarCourses::query()->where(['certifeca' => $certifeca,'year' => $year]);
//                else
              $stsico=Course::query()->where(['student_id' => $student_id])->get();
                $stsico=$stsico&&Course::query()->where('is_similar', '=','1');

                //$stsico=$stsico->paginate('25');

                return SimilarCoursesResource::collection($stsico);

            }
            else return SimilarCoursesResource::returnMsg('الطالب غير موجود', 400, false);
            }
            catch (ValidationException $exv) {
                    return SimilarCoursesResource::exception($exv);
                }
    }
                    }
