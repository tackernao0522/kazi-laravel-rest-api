<?php

use App\Http\Controllers\Api\SclassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/class', [SclassController::class, 'index']);