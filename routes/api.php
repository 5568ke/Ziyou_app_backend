<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\PaperController;
use GuzzleHttp\Middleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/test',function(){
    return 'hello';
});

Route::post('/register/teacher', [TeacherController::class, 'register']);
Route::post('/login/teacher', [TeacherController::class, 'login']);
Route::post('/register/student', [StudentController::class, 'register']);
Route::post('/login/student', [StudentController::class, 'login']);

// Route::group(['middleware'=>['auth:sanctum_teacher','refresh.token.expirtaion']],function(){
Route::group(['middleware'=>['auth:sanctum_teacher', 'refresh.token.expiration']],function(){
    Route::post('/teacher/logout',[TeacherController::class,'logout']);
    Route::get('/user',[TeacherController::class,'getTeacher']);

    Route::post('/teacher/createClass',[ClasseController::class,'createClass']);
    Route::get('/teacher/getAllClass',[ClasseController::class,'getAllClasses']);
    Route::delete('/teacher/deleteClass',[ClasseController::class,'deleteClass']);

    Route::post('/teacher/createPaper',[PaperController::class,'createPaper']);
    Route::post('/teacher/getAllPaper_teacher',[PaperController::class,'getAllPaper_teacher']);
    Route::post('/teacher/updatePaper',[PaperController::class,'updatePaper']);
    Route::delete('/teacher/deletePaper',[PaperController::class,'deletePaper']);
});

// Route::group(['middleware'=>['auth:sanctum_student','refresh.token.expiration']],function(){
Route::group(['middleware'=>['auth:sanctum_student', 'refresh.token.expiration']],function(){
    Route::get('student/getAllPaper_student',[PaperController::class,'getAllPaper_student']);
    Route::post('student/logout',[StudentController::class,'logout']);
    Route::post('student/enterclass',[StudentController::class,'enterclass']);
});


