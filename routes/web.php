<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;

// Redirect root to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Admin routes
// Admin Routes
Route::prefix('admin')->group(function () {
    // Login routes (public)
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    
    // Dashboard routes (need auth)
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
        
        // User Management
        Route::get('/users', [AdminDashboardController::class, 'getUsers'])->name('admin.users.index');
        Route::post('/users', [AdminDashboardController::class, 'createUser'])->name('admin.users.create');
        Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Food Management
        Route::get('/foods', [AdminDashboardController::class, 'getFoods'])->name('admin.foods.index');
        Route::post('/foods', [AdminDashboardController::class, 'createFood'])->name('admin.foods.create');
        Route::put('/foods/{food}', [AdminDashboardController::class, 'updateFood'])->name('admin.foods.update');
        Route::delete('/foods/{food}', [AdminDashboardController::class, 'deleteFood'])->name('admin.foods.delete');
    });
});