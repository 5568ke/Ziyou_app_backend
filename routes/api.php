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

Route::get('unAuth',function(){
    return response()->json(['error' => 'Unauthenticated'], 401);
})->name('unAuth');



Route::post('register/teacher', [TeacherController::class, 'register']);                            //對應的 api : 老師註冊
Route::post('login/teacher', [TeacherController::class, 'login']);                                  //對應的 api : 老師登入
Route::post('register/student', [StudentController::class, 'register']);                            //對應的 api : 學生註冊
Route::post('login/student', [StudentController::class, 'login']);                                  //對應的 api : 學生登入

Route::group(['middleware'=>['auth:sanctum_teacher', 'refresh.token.expiration']],function(){
    Route::post('teacher/logout',[TeacherController::class,'logout']);                              //對應的 api : 老師登出

    Route::post('teacher/update_login',[TeacherController::class,'update_login']);                  //對應的 api : 更新登入狀態
    Route::post('teacher/createClass',[ClasseController::class,'createClass']);                     //對應的 api : 建立班級
    Route::get('teacher/getAllClass',[ClasseController::class,'getAllClasses']);                    //對應的 api : 取得班級
    Route::delete('teacher/deleteClass',[ClasseController::class,'deleteClass']);                   //對應的 api : 刪除班級

    Route::post('teacher/createPaper',[PaperController::class,'createPaper']);                      //對應的 api : 建立試卷
    Route::post('teacher/getAllPaper',[PaperController::class,'getAllPaper_teacher']);              //對應的 api : 取得試卷
    Route::post('teacher/getPaper',[PaperController::class,'getPaper']);                            //對應的 api : 取得題目
    Route::post('teacher/updatePaper',[PaperController::class,'updatePaper']);                      //對應的 api : 更新試卷
    Route::delete('teacher/deletePaper',[PaperController::class,'deletePaper']);                    //對應的 api : 刪除試卷
    Route::post('teacher/getAllPaperRecord',[PaperController::class,'getAllPaperRecord']);          //對應的 api : 取得所有作業紀錄
    Route::post('teacher/markPapers',[PaperController::class,'markPapers']);                        //對應的 api : 批改試卷並發布試卷成績
});

Route::group(['middleware'=>['auth:sanctum_student', 'refresh.token.expiration']],function(){
    Route::get('student/getAllPaper',[PaperController::class,'getAllPaper_student']);                 //對應的 api : 取得作業
    Route::post('student/update_login',[StudentController::class,'update_login']);                    //對應的 api : 更新登入狀態
    Route::post('student/getPaperRecord',[PaperController::class,'getPaperRecord_student']);          //對應的 api : 取得作業紀錄
    Route::post('student/updatePaperRecord',[PaperController::class,'updatePaperRecord']);            //對應的 api : 更改作業紀錄
    Route::post('student/getPaper',[PaperController::class,'getPaper']);                              //對應的 api : 取得題目
    Route::post('student/logout',[StudentController::class,'logout']);                                //對應的 api : 學生登出
    Route::post('student/enterClass',[StudentController::class,'enterclass']);                        //對應的 api : 加入班級
    Route::post('student/createProblemRecord',[PaperController::class,'createProblemRecord']);        //對應的 api : 建立作業紀錄
});

