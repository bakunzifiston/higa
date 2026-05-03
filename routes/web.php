<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
// Protected routes with role-based access (all role types from ImsMenu)
    Route::middleware('role:admin,collection-officer,production-manager,sales-team,manager,clerk')->group(function (): void {
        Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
        Route::get('/modules/{module}/{id}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::post('/modules/{module}', [ModuleController::class, 'store'])->name('modules.store');
        Route::put('/modules/{module}/{id}', [ModuleController::class, 'update'])->name('modules.update');
        Route::delete('/modules/{module}/{id}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    });
    
    // Admin-only user management routes
    Route::middleware('role:admin')->group(function (): void {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
