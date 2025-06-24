<?php

use App\Http\Controllers\LessonController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'authenticate']);

Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware'=>'auth:sanctum', 'throttle:180,1'], function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/userIdOut', [UserController::class, 'getUserId']);
    Route::post('/registerUserProgress',[UserController::class, 'userRegisterProgress']);
    Route::post('/changeAvatar',[UserController::class, 'changeAvatar']);
    Route::post('/changePassword',[UserController::class, 'changePassword']);
    Route::post('/deleteUser',[UserController::class, 'deleteUser']);

    //---------------------------------------------------------

    // Уроки
    Route::post('/lessons/add',[LessonController::class, 'LessonAdd']);
    Route::delete('/lessons/{lesson}',[LessonController::class, 'LessonDestroy']);
    Route::patch('/lessons/{lesson}',[LessonController::class, 'LessonEdit']);

    // Материалы
    Route::post('/lesson/{lesson}/materials/add',[MaterialController::class,'uploadFileTheory']);
    Route::post('/lesson/{lesson}/materials/add/relative',[MaterialController::class,'uploadFileRelative']);
    Route::post('/lesson/{lesson}/materials/add/daughter',[MaterialController::class,'uploadFileDaughter']);

    Route::delete('/materials/{material}',[MaterialController::class, 'deleteFileAny']);
    Route::patch('/materials/{material}/update',[MaterialController::class, 'updateMaterial']);

    // Состояния
    Route::post('/states/add/{material}',[StateController::class, 'createState']);
    Route::delete('/states/delete/{state}',[StateController::class, 'deleteState']);

    // --------------------------------------------------------------

    // Пользователи
    Route::get('/users',[UserController::class, 'outAllUsers']);

    // --------------------------------------------------------------

    Route::post('/game/progress',[ProgressController::class,'outUserProgressLessons']);
    Route::post('/progress/find-next',[ProgressController::class,'findNextLesson']);
    Route::post('/progress/done-lesson',[ProgressController::class,'doneLesson']);
});

Route::get('lessons',[LessonController::class, 'index']);
Route::get('lesson/{url_title}',[LessonController::class, 'getLesson']);
