<?php

namespace App\Http\Controllers;


use App\Http\Resources\StudentResource;
use App\Models\Register;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;



class StudentController extends Controller
{

    public function createStudent(Request $request)
    {

        try {

            $rules = [
                'fullname' => 'required',
                'fathername' => 'required',
                'mothername' => 'required',
                'birthplace' => 'required',
                'birthdate' => 'required',
                'gender' => 'required',
                'national_num' => 'required',
                'certifeca' => 'required',
                'specialization' => 'required',
                'university_num' => 'required'

            ];
            $validation = $request->validate($rules);


            //parms from request
            $university_num = $request->university_num;
            $specialization = $request->specialization;

            $student = Student::query()->where(['university_num' => $university_num, 'specialization' => $specialization])->first();
            if (!($student)) {
                $new_student = Student::query()->create([

                        'fullname' => $request->input('fullname'),
                        'fathername' => $request->input('fathername'),
                        'mothername' => $request->input('mothername'),
                        'birthplace' => $request->input('birthplace'),
                        'birthdate' => $request->input('birthdate'),
                        'gender' => $request->input('gender'),
                        'place_num_registration' => $request->input('place_num_registration'),
                        'nationality' => $request->input('nationality'),
                        'address' => $request->input('address'),
                        'phone' => $request->input('phone'),
                        'recruitment_division' => $request->input('recruitment_division'),
                        'national_num' => $request->input('national_num'),
                        'homephone' => $request->input('homephone'),
                        'university_num' => $request->input('university_num'),
                        'certifeca' => $request->input('certifeca'),
                        'specialization' => $request->input('specialization'),
                    ]
                );

                return StudentResource::returnMsg("تم تسجيل الطالب بنجاح", 200);;
            }
            else
                return StudentResource::returnMsg("الطالب موجود !", 400);
        }
        catch (ValidationException $exv) {
            return StudentResource::exception($exv);
        }

    }

    public function updateStudent(Request $request)
    {

        try {
            $rules = [
                'university_num' => 'required',
                'specialization' => 'required'

            ];
            $validator = $request->validate($rules);


            //parms from request
            $university_num = $request->university_num;
            $specialization = $request->specialization;

            $student = Student::query()->where(['university_num' => $university_num, 'specialization' => $specialization])->first();

            if($student) {
                $newfullname = $request->fullname;
                if ($newfullname)
                    $student->fullname = $newfullname;

                $newfathername = $request->fathername;
                if ($newfathername)
                    $student->fathername = $newfathername;

                $newmothername = $request->mothername;
                if ($newmothername)
                    $student->mothername = $newmothername;

                $newbirthplace = $request->birthplace;
                if ($newbirthplace)
                    $student->birthplace = $newbirthplace;

                $newbirthdate = $request->birthdate;
                if ($newbirthdate)
                    $student->birthdate = $newbirthdate;

                $newgender = $request->gender;
                if ($newgender)
                    $student->gender = $newgender;

                $national_num = $request->national_num;
                if ($national_num)
                    $student->national_num = $request->national_num;

                $newcertifeca = $request->certifeca;
                if ($newcertifeca)
                    $student->certifeca = $newcertifeca;

                $student->place_num_registration = $request->input('place_num_registration');
                $student->nationality = $request->input('nationality');
                $student->address = $request->input('address');
                $student->phone = $request->input('phone');
                $student->recruitment_division = $request->input('recruitment_division');
                $student->homephone = $request->input('homephone');


                $student->update();

                return StudentResource::returnMsg('تم تعديل الطالب بنجاح', 200, true);
            }
            else return StudentResource::returnMsg('الطالب غير موجود', 400, false);
        } catch (ValidationException $exv) {
            return StudentResource::exception($exv);

        }
    }


    public function getStd(Request $request){
        try {

            $specialization=$request->specialization;
            $student = Student::query();
            if ($request->has('specialization')) {
                $student = $student->where('specialization', $specialization);
                $studentIds=Student::where(['specialization'=>$specialization])->pluck('id')
                    -> toArray();
            }
            if ($request->has('year') and $request->year!='all') {
                $studentIds = Register::query()->where('year', $request->year)->pluck('student_id')
                    -> toArray();
                $student = $student->whereIn('id', $studentIds)
                ->where(['specialization'=>$specialization]);
            }
            if ($request->has('certifeca') and $request->certifeca!='all' ) {
                $student = $student->where(['certifeca'=>$request->certifeca,'specialization'=>$specialization])->whereIn('id', $studentIds);
            }

            $student = $student->get();


            //  $student=$student->paginate('25');
            return StudentResource::paginable($student);
        }
        catch (ValidationException $exv){
            return StudentResource::exception($exv);
        }

    }


    public function searchForStudent(Request $request)
    {
        try {

            $rules = [
                'university_num' => 'required',
                'specialization' => 'required'

            ];
            $validator = $request->validate($rules);

            //parms from request
            $university_num = $request->university_num;
            $specialization = $request->specialization;

            $student = Student::query()->where(['university_num' => $university_num, 'specialization' => $specialization])->first();
            if($student) {
                return StudentResource::create($student);
            }    else return StudentResource::returnMsg('الطالب غير موجود', 400, false);


        } catch (ValidationException $exv) {

            return StudentResource::exception($exv);

        }
    }

}
