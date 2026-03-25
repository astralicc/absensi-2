<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserController;

// Device integration
Route::post('/device/attendance', [AttendanceController::class, 'store']);
Route::get('/device/logs', [AttendanceController::class, 'logs']);

// View attendance
Route::get('/attendances', [AttendanceController::class, 'index']);
Route::get('/attendances/{id}', [AttendanceController::class, 'show']);

// Manage users
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);