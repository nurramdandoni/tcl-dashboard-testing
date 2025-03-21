<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);
Route::get('/dashboard', [DashboardController::class, 'dashboard']);
Route::post('/dataBar', [DashboardController::class, 'getdataBarChart']);
Route::get('/dataTgl', [DashboardController::class, 'getdataTanggal']);

