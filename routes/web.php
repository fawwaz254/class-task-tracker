<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;


    // Halaman awal
    Route::get('/', function () {
        return redirect('/login');
    });

    // Register dan Login hanya untuk pengguna yang belum login
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AuthController::class, 'showRegister']);
        Route::post('/register', [AuthController::class, 'register']);

        Route::get('/login', [AuthController::class, 'showLogin']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Halaman yang hanya bisa diakses setelah login
    Route::middleware('auth')->group(function () {

        // Pengalihan dashboard berdasarkan role
        Route::get('/dashboard', function (Request $request) {
            $user = $request->user();

            if ($user->role === 'teacher') {
                return redirect('/teacher/dashboard');
            }

            return redirect('/student/dashboard');
        });

        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });

    // Route khusus guru
    Route::middleware(['auth', 'role:teacher'])->group(function () {

        Route::get('/teacher/dashboard', function () {
            return view('dashboard.teacher');
        });

    });

    // Route khusus siswa
    Route::middleware(['auth', 'role:student'])->group(function () {

        Route::get('/student/dashboard', function () {
            return view('dashboard.student');
        });

    });