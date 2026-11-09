<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\TeacherTaskController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // API khusus siswa
    Route::get('/student/tasks', [TaskController::class, 'index']);
    Route::post('/student/tasks/{task}/complete', [TaskController::class, 'complete']);

    // API khusus guru
    Route::middleware('role:teacher')->prefix('teacher')->group(function () {
    Route::get('/tasks', [TeacherTaskController::class, 'index']);
    Route::post('/tasks', [TeacherTaskController::class, 'store']);
    Route::put('/tasks/{task}', [TeacherTaskController::class, 'update']);
    Route::delete('/tasks/{task}', [TeacherTaskController::class, 'destroy']);
});
});
