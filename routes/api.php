<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;    
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubCourseController;

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

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('getAllUser', [AuthController::class, 'getUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
});

Route::post('register/admin', [\App\Http\Controllers\AdminController::class, 'register']);
Route::post('login/admin', [\App\Http\Controllers\AdminController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('admin', [\App\Http\Controllers\AdminController::class, 'user']);
    Route::post('logout/admin', [\App\Http\Controllers\AdminController::class, 'logout']);
});

//CRUD for Grade
Route::post('/createGrade', [GradeController::class, 'create']);
Route::get('/getAllGrade', [GradeController::class, 'getAll']);
Route::get('/getOneGrade/{id}', [GradeController::class, 'getOne']);
Route::put('/update/{id}', [GradeController::class, 'update']);
Route::delete('/delete/{id}', [GradeController::class, 'delete']);

//CRUD for Course
Route::post('/createCourse',[CourseController::class,'create']);
Route::get('/getAllCourse', [CourseController::class, 'getAllCourses']);
Route::get('/getOneCourse/{id}', [CourseController::class, 'getOneCourse']);
Route::put('/updateCourse/{id}', [CourseController::class, 'update']);
Route::delete('/deleteCourse/{id}', [CourseController::class, 'delete']);

//CRUD for SubCourse
Route::post('/createSubCourse', [SubcourseController::class, 'create']);
Route::get('/getAllSubCourse', [SubCourseController::class, 'getAll']);
Route::get('/getOneSubCourse/{id}', [SubcourseController::class, 'getOne']);
Route::put('/updateSubCourse/{id}', [SubcourseController::class, 'update']);
Route::delete('/deleteSubCourse/{id}', [SubcourseController::class, 'delete']);