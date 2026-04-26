<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
    Route::post('/modules/{module}', [ModuleController::class, 'store'])->name('modules.store');
    Route::put('/modules/{module}/{id}', [ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/modules/{module}/{id}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
