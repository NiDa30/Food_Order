<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\Admin\AdminUserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/food', [FoodController::class, 'index']);
    Route::get('/food/{food}', [FoodController::class, 'show']);
});

Route::middleware(['auth:sanctum', 'can:manage-food'])->group(function () {
    Route::post('/admin/food', [FoodController::class, 'store']);
    Route::put('/admin/food/{food}', [FoodController::class, 'update']);
    Route::delete('/admin/food/{food}', [FoodController::class, 'delete']);
});

Route::middleware(['auth:sanctum', 'can:manage-users'])->group(function () {
    Route::get('/admin/users', [AdminUserController::class, 'index']);
    Route::get('/admin/users/{user}', [AdminUserController::class, 'show']);
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy']);
});