<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/user', [UserController::class,'index']);
Route::get('/st', [StudentsController::class,'index']);
Route::get('/stud', [StudentsController::class,'show']);
Route::get('/st/{id}', [StudentsController::class,'show']);
Route::get('/user/{id}', [UserController::class,'show']);
Route::post('/users', [UserController::class,'show']);
Route::post('/addus', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);
Route::get('/login', [UserController::class,'login']);
Route::get('/logout', [UserController::class,'logout']);
Route::get('/home', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\UserController::class, 'get_user'])->name('home');
