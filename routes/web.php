<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', \App\Http\Controllers\DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Module CRUD routes (used by ImsMenu: modules.show/modules.edit/etc)
    Route::middleware('role:admin,collection-officer,production-manager,sales-team,manager,clerk')->group(function () {
        Route::get('/modules/{module}', [ModuleController::class, 'show'])->name('modules.show');
        Route::get('/modules/{module}/{id}/edit', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::post('/modules/{module}', [ModuleController::class, 'store'])->name('modules.store');
        Route::put('/modules/{module}/{id}', [ModuleController::class, 'update'])->name('modules.update');
        Route::delete('/modules/{module}/{id}', [ModuleController::class, 'destroy'])->name('modules.destroy');
    });

    // Admin-only user management routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});

require __DIR__.'/auth.php';

