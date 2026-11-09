<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;


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
    Route::get('/dashboard', function () {
    $user = Auth::user();
    return 'Login berhasil! Selamat datang, ' . $user->name;
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});