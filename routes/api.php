<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\CheckExamController;
use App\Http\Controllers\ExamClassController;
use App\Http\Controllers\PunishmentsController;
use App\Http\Controllers\stController;
use App\Models\Student;
use App\Models\student_courses;
use App\Models\student_courses_state;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [UserController::class, 'login'])->middleware('guest');
Route::post('/transfer', [\App\Http\Controllers\TransferController::class, 'transfer']);

Route::post('/stop', [\App\Http\Controllers\StopController::class, 'stop']);

Route::post('/suspension', [\App\Http\Controllers\SuspensionController::class, 'suspension']);

Route::post('/createStudent', [\App\Http\Controllers\StudentController::class, 'createStudent']);
Route::post('/updateStudent', [\App\Http\Controllers\StudentController::class, 'updateStudent']);
Route::post('/getStudents', [\App\Http\Controllers\StudentController::class, 'getStd']);
Route::post('/searchForStudent', [\App\Http\Controllers\StudentController::class, 'searchForStudent']);
Route::post('/GetLastUnvBySpec', [stController::class, 'GetLastUnvBySpec']);

Route::post('/graduate', [\App\Http\Controllers\GraduationController::class, 'graduation']);
Route::post('/allsraduatest', [\App\Http\Controllers\GraduationController::class, 'getGraduateStudents']);

Route::post('/registeryear', [\App\Http\Controllers\RegisterController::class, 'register']);

Route::get('/getLogs', [\App\Http\Controllers\LogController::class, 'get_log_users']);
Route::group(['middleware' => 'J4Auth'], function () {

    Route::post('/deleteU', [UserController::class, 'delete_user']);
    Route::post('/changePass', [UserController::class, 'change_Password']);
    Route::get('/logout', [UserController::class, 'logout']);

    Route::get('/who', [UserController::class, 'get_user']);
    Route::get('/user', [UserController::class, 'get_users']);
    Route::post('/giveper', [UserController::class, 'give_Permission_user']);
    Route::post('/getuserper', [UserController::class, 'UserPer']);
    Route::get('/getuser', [UserController::class, 'show_user']);
    Route::post('/upuser', [UserController::class, 'update_user']);/**/
    Route::post('/ExamByCourse', [ExamController::class, 'getExamByCourse']);
    Route::post('/ExamByStudent', [ExamController::class, 'getExamByStudent']);
    Route::post('/addus', [UserController::class, 'create_user']);//->middleware('HavePermission');

});
Route::get('/st/{id}', [StudentsController::class, 'show_user']);
Route::post('/users', [UserController::class, 'show']);
Route::get('/setup', [\App\Http\Controllers\SetupPerRol::class, 'setupRolesAndPER']);
//////////////////

Route::post('/add_course', [CourseController::class, 'add_course']);
Route::post('/getCourseByCode', [CourseController::class, 'getCourseByCode']);
Route::post('/updateCourse', [CourseController::class, 'updateCourse']);
Route::post('/getCourseBysemster', [CourseController::class, 'getCourseBysemster']);
Route::post('/showAllCourses', [CourseController::class, 'get_all_courses']);
Route::post('/deleteCourse', [CourseController::class, 'deleteCourse']);
Route::post('/getAvailableStudCourses', [CourseController::class, 'get_availableStudCourses']);
Route::post('/AttatchStudentCourses', [CourseController::class, 'AttatchStudentCourses']);
Route::post('/addExamClass', [ExamClassController::class, 'addClassEx']);
Route::post('/showAllClasses', [ExamClassController::class, 'showAllClasses']);
Route::post('/DeleteExamClass', [ExamClassController::class, 'DeleteExamClass']);
Route::post('/setExamClassReady', [ExamClassController::class, 'setExamClassReady']);
Route::post('/UpdateExamClass', [ExamClassController::class, 'UpdateExamClass']);
Route::post('/getCheckSess', [CheckExamController::class, 'getCheckExAdmin']);
Route::post('/transferCheckExAdmin', [ExamController::class, 'transferCheckExAdmin']);
//Route::post('/AddCheckEx',[CheckExamController::class,'AddCheckEx']);
Route::post('/PutStudentsInClassByCourse', [CheckExamController::class, 'PutStudentsInClassByCourse']);
Route::post('/AddMarksCheckEx', [CheckExamController::class, 'AddMarksCheckEx']);
Route::post('/getExamByCourse', [ExamController::class, 'getExamByCourse']);
Route::any('/getMarksStudent', [ExamController::class, 'getMarksStudent']);
Route::get('/getStudyYearsList', [ExamController::class, 'getStudyYearsList']);
Route::post('/getMarksByYearStudent', [ExamController::class, 'getMarksByYearStudent']);
Route::post('/StudentCourses', [ExamController::class, 'StudentCourses']);
Route::post('/getStudentPunishments', [PunishmentsController::class, 'getStudentPunishments']);
Route::post('/createPunishment', [PunishmentsController::class, 'createPunishment']);
Route::post('/getAllPunishments', [PunishmentsController::class, 'getAllPunishments']);
Route::post('/deletePunishment', [PunishmentsController::class, 'deletePunishment']);
Route::post('/updatePunishmet', [PunishmentsController::class, 'updatePunishmet']);
Route::post('/getStudentSituation', [stController::class, 'getStudentSituation']);
Route::post('/AvgForGradStud', [stController::class, 'AvgForGradStud']);








