<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AttendanceController::class, 'index']);

// Student Routes
Route::get('/student/create', [AttendanceController::class, 'create']);
Route::post('/student/store', [AttendanceController::class, 'store']);

// Attendance Routes
Route::get('/attendance', [AttendanceController::class, 'markAttendance']);
Route::post('/attendance/store', [AttendanceController::class, 'storeAttendace']);

// Report Route
Route::get('/report', [AttendanceController::class, 'report']);