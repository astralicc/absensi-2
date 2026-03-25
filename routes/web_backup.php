<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceHistoryController;
use App\Http\Controllers\AttendanceManageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildAttendanceController;
use App\Http\Controllers\ChildDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentListController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
})->name('home');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/signup', [AuthController::class, 'redirectToGoogleSignup'])->name('google.signup');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Hidden Admin Routes (not exposed in public UI)
Route::get('/x-admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/x-admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

// Role-based Dashboard Routes
Route::middleware(['auth'])->group(function () {
    // Murid (Student) Dashboard
    Route::get('/dashboard/murid', [DashboardController::class, 'murid'])
        ->middleware('role:' . User::ROLE_MURID)
        ->name('dashboard.murid');

    // Guru (Teacher) Dashboard
    Route::get('/dashboard/guru', [DashboardController::class, 'guru'])
        ->middleware('role:' . User::ROLE_GURU)
        ->name('dashboard.guru');

    // Orang Tua (Parent) Dashboard
    Route::get('/dashboard/orang-tua', [DashboardController::class, 'orangTua'])
        ->middleware('role:' . User::ROLE_ORANGTUA)
        ->name('dashboard.orangtua');

    // Default Dashboard (redirects based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Murid Routes
    Route::middleware('role:' . User::ROLE_MURID)->group(function () {
        Route::get('/riwayat-absensi', [AttendanceHistoryController::class, 'index'])
            ->name('attendance.history');
        Route::get('/jadwal-pelajaran', [ScheduleController::class, 'index'])
            ->name('schedule.index');
    });

    // Guru Routes
    Route::middleware('role:' . User::ROLE_GURU)->group(function () {
        Route::get('/kelola-absensi', [AttendanceManageController::class, 'index'])
            ->name('attendance.manage');
        Route::post('/kelola-absensi/mark', [AttendanceManageController::class, 'markAttendance'])
            ->name('attendance.mark');
        Route::post('/kelola-absensi/bulk-mark', [AttendanceManageController::class, 'bulkMarkAttendance'])
            ->name('attendance.bulk-mark');
        Route::get('/daftar-siswa', [StudentListController::class, 'index'])
            ->name('students.index');
        Route::get('/daftar-siswa/{id}', [StudentListController::class, 'show'])
            ->name('students.show');
        
        // Schedule Management Routes for Guru
        Route::get('/kelola-jadwal', [ScheduleController::class, 'manage'])
            ->name('schedule.manage');
        Route::get('/kelola-jadwal/create', [ScheduleController::class, 'create'])
            ->name('schedule.create');
        Route::post('/kelola-jadwal', [ScheduleController::class, 'store'])
            ->name('schedule.store');
        Route::get('/kelola-jadwal/{schedule}/edit', [ScheduleController::class, 'edit'])
            ->name('schedule.edit');
        Route::put('/kelola-jadwal/{schedule}', [ScheduleController::class, 'update'])
            ->name('schedule.update');
        Route::delete('/kelola-jadwal/{schedule}', [ScheduleController::class, 'destroy'])
            ->name('schedule.destroy');
        
        Route::get('/laporan', [ReportController::class, 'index'])
            ->name('reports.index');
        Route::get('/laporan/export', [ReportController::class, 'export'])
            ->name('reports.export');
    });

    // Orang Tua Routes
    Route::middleware('role:' . User::ROLE_ORANGTUA)->group(function () {
        Route::get('/data-anak', [ChildDataController::class, 'index'])
            ->name('children.data');
        Route::get('/data-anak/{id}', [ChildDataController::class, 'show'])
            ->name('children.show');
        Route::get('/absensi-anak', [ChildAttendanceController::class, 'index'])
            ->name('children.attendance');
        Route::get('/absensi-anak/kalender', [ChildAttendanceController::class, 'calendar'])
            ->name('children.calendar');
    });

    // Announcements (All Roles)
    Route::get('/pengumuman', [AnnouncementController::class, 'index'])
        ->name('announcements.index');
    Route::get('/pengumuman/{id}', [AnnouncementController::class, 'show'])
        ->name('announcements.show');

    // Admin Routes (Hidden from public)
    Route::middleware('role:' . User::ROLE_ADMIN)->group(function () {
        Route::get('/x-admin/dashboard', function () {
            $totalUsers = User::count();
            $totalStudents = User::where('role', User::ROLE_MURID)->count();
            $totalTeachers = User::where('role', User::ROLE_GURU)->count();
            $totalParents = User::where('role', User::ROLE_ORANGTUA)->count();
            
            return view('admin.dashboard', compact('totalUsers', 'totalStudents', 'totalTeachers', 'totalParents'));
        })->name('admin.dashboard');

        // Admin Announcement Management Routes
        Route::get('/x-admin/pengumuman', [AnnouncementController::class, 'adminIndex'])
            ->name('admin.announcements.index');
        Route::get('/x-admin/pengumuman/create', [AnnouncementController::class, 'create'])
            ->name('admin.announcements.create');
        Route::post('/x-admin/pengumuman', [AnnouncementController::class, 'store'])
            ->name('admin.announcements.store');
        Route::get('/x-admin/pengumuman/{id}/edit', [AnnouncementController::class, 'edit'])
            ->name('admin.announcements.edit');
        Route::put('/x-admin/pengumuman/{id}', [AnnouncementController::class, 'update'])
            ->name('admin.announcements.update');
        Route::delete('/x-admin/pengumuman/{id}', [AnnouncementController::class, 'destroy'])
            ->name('admin.announcements.destroy');
    });
});

require __DIR__ . '/settings.php';
