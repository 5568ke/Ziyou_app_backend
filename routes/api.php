<?php

use App\Http\Controllers\ClasseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
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

Route::post('/register/teacher', [TeacherController::class, 'register']);
Route::post('/login/teacher', [TeacherController::class, 'login']);

Route::group(['middleware'=>['auth:sanctum_teacher']],function(){
    Route::post('/teacher/logout',[TeacherController::class,'logout']);
    Route::get('/user',[TeacherController::class,'getTeacher']);
    Route::post('/teacher/makeClass',[ClasseController::class,'makeClass']);
});

