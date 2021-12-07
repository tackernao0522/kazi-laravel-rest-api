<?php

use App\Http\Controllers\Api\SclassController;
use App\Http\Controllers\Api\SectionController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SubjectController;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Student Class Routes
Route::get('/class', [SclassController::class, 'index']);
Route::post('/class/store', [SclassController::class, 'store']);
Route::get('/class/edit/{id}', [SclassController::class, 'edit']);
Route::post('/class/update/{id}', [SclassController::class, 'update']);
Route::get('/class/delete/{id}', [SclassController::class, 'delete']);

// Subject Class Routes
Route::get('/subject', [SubjectController::class, 'sectionIndex']);
Route::post('/subject/store', [SubjectController::class, 'store']);
Route::get('/subject/edit/{id}', [SubjectController::class, 'subEdit']);
Route::post('/subject/update/{id}', [SubjectController::class, 'update']);
Route::get('/subject/delete/{id}', [SubjectController::class, 'delete']);

// Section Routes
Route::get('/section', [SectionController::class, 'sectionIndex']);
Route::post('/section/store', [SectionController::class, 'store']);
Route::get('/section/edit/{id}', [SectionController::class, 'sectionEdit']);
Route::post('/section/update/{id}', [SectionController::class, 'sectionUpdate']);
Route::get('/section/delete/{id}', [SectionController::class, 'sectionDelete']);

// Student Routes
Route::get('student', [StudentController::class, 'studentIndex']);
Route::post('/student/store', [StudentController::class, 'studentStore']);

