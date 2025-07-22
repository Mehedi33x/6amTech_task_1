<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.list');
    Route::post('user/create', [UserController::class, 'store'])->name('user.store');
    Route::delete('user/delete/{id}', [UserController::class, 'destroy']);
    // for the task api
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/task-create', [TaskController::class, 'store']);
    Route::get('/task-detail/{id}', [TaskController::class, 'show']);
    Route::post('/task-update/{id}', [TaskController::class, 'update']);
    Route::delete('/task-delete/{id}', [TaskController::class, 'destroy']);

    Route::get('user', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);
});
