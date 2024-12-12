<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('employees', \App\Http\Controllers\EmployeeController::class);
    Route::put('employees/activate/{employee}', [\App\Http\Controllers\EmployeeController::class, 'activate']);
    Route::put('users/{user}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    //attendance
    Route::controller(\App\Http\Controllers\AttendanceController::class)->group(function () {
        Route::get('/attendance', 'show');
        Route::post('/attendance-check-in', 'checkIn');
        Route::post('/attendance-check-out', 'checkOut');
    });
});

