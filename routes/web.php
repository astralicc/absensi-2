<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceHistoryController;
use App\Http\Controllers\AttendanceManageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildAttendanceController;
use App\Http\Controllers\ChildDataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentListController;
use App\Http\Controllers\AdminSettingController;

use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\AdminGuruController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminRekapController;
use App\Http\Controllers\AdminExportController;
use App\Http\Controllers\AdminParentController;

use App\Models\Siswa;
use App\Models\Guru;
use App\Models\OrangTua;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  $announcements = \App\Models\Announcement::active()->recent()->limit(5)->get();
  return view('app', compact('announcements'));
})->name('home');


Route::get('/about', function () {
  return view('about');
})->name('about');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Hidden Admin Routes (not exposed in public UI)
Route::get('/x-admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/x-admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.post');

// Default Dashboard (redirects based on guard)
Route::middleware(['auth:web,guru,admin,ortu'])->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

  // Announcements (All Roles)
  Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('announcements.index');
  Route::get('/pengumuman/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');

  // Profile Routes (All authenticated users)
  Route::get('/profil/edit', [ProfileController::class, 'showEditProfile'])->name('profile.edit');
  Route::put('/profil', [ProfileController::class, 'updateProfile'])->name('profile.update');
});

// Siswa (Murid) Routes — guard: web
Route::middleware(['auth:web'])->group(function () {
  Route::get('/dashboard/murid', [DashboardController::class, 'murid'])->name('dashboard.murid');
  Route::get('/riwayat-absensi', [AttendanceHistoryController::class, 'index'])->name('attendance.history');
  Route::get('/jadwal-pelajaran', [ScheduleController::class, 'index'])->name('schedule.index');
  Route::get('/lapor-absensi', [AttendanceHistoryController::class, 'report'])->name('attendance.report');
});

// Guru Routes — guard: guru
Route::middleware(['auth:guru'])->group(function () {
  Route::get('/dashboard/guru', [DashboardController::class, 'guru'])->name('dashboard.guru');
  Route::get('/kelola-absensi', [AttendanceManageController::class, 'index'])->name('attendance.manage');
  Route::post('/kelola-absensi/mark', [AttendanceManageController::class, 'markAttendance'])->name('attendance.mark');
  Route::post('/kelola-absensi/bulk-mark', [AttendanceManageController::class, 'bulkMarkAttendance'])->name('attendance.bulk-mark');
  Route::get('/daftar-siswa', [StudentListController::class, 'index'])->name('students.index');
  Route::get('/daftar-siswa/{id}', [StudentListController::class, 'show'])->name('students.show');

  // Schedule Management
  Route::get('/kelola-jadwal', [ScheduleController::class, 'manage'])->name('schedule.manage');
  Route::get('/kelola-jadwal/create', [ScheduleController::class, 'create'])->name('schedule.create');
  Route::post('/kelola-jadwal', [ScheduleController::class, 'store'])->name('schedule.store');
  Route::get('/kelola-jadwal/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
  Route::put('/kelola-jadwal/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
  Route::delete('/kelola-jadwal/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');

  Route::get('/laporan', [ReportController::class, 'index'])->name('reports.index');
  Route::get('/laporan/export', [ReportController::class, 'export'])->name('reports.export');

  // Wali Kelas Routes (guru with kelas_wali)
  Route::middleware(['wali-kelas'])->prefix('wali-kelas')->name('wali-kelas.')->group(function () {
    Route::get('/', [WaliKelasController::class, 'waliDashboard'])->name('index');
    Route::get('/siswa', [StudentListController::class, 'index'])->name('students');
  });
});

// Orang Tua Routes — guard: ortu
Route::middleware(['auth:ortu'])->group(function () {
  Route::get('/dashboard/orang-tua', [DashboardController::class, 'orangTua'])->name('dashboard.orangtua');
  Route::get('/data-anak', [ChildDataController::class, 'index'])->name('children.data');
  Route::get('/data-anak/{id}', [ChildDataController::class, 'show'])->name('children.show');
  Route::get('/absensi-anak', [ChildAttendanceController::class, 'index'])->name('children.attendance');
  Route::get('/absensi-anak/kalender', [ChildAttendanceController::class, 'calendar'])->name('children.calendar');
});

// Admin Routes — guard: admin
Route::middleware(['auth:admin'])->group(function () {
  Route::get('/x-admin/dashboard', function () {
    $totalStudents = Siswa::count();
    $totalTeachers = Guru::count();
    $totalParents = OrangTua::count();
    $totalUsers = $totalStudents + $totalTeachers + $totalParents;

    return view('admin.dashboard', compact('totalUsers', 'totalStudents', 'totalTeachers', 'totalParents'));
  })->name('admin.dashboard');

  // Admin Announcement Management
  Route::get('/x-admin/pengumuman', [AnnouncementController::class, 'adminIndex'])->name('admin.announcements.index');
  Route::get('/x-admin/pengumuman/create', [AnnouncementController::class, 'create'])->name('admin.announcements.create');
  Route::post('/x-admin/pengumuman', [AnnouncementController::class, 'store'])->name('admin.announcements.store');
  Route::get('/x-admin/pengumuman/{id}/edit', [AnnouncementController::class, 'edit'])->name('admin.announcements.edit');
  Route::put('/x-admin/pengumuman/{id}', [AnnouncementController::class, 'update'])->name('admin.announcements.update');
  Route::delete('/x-admin/pengumuman/{id}', [AnnouncementController::class, 'destroy'])->name('admin.announcements.destroy');

  // Admin Settings
  Route::get('/x-admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
  Route::post('/x-admin/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

  // Admin Wali Kelas Management
  Route::get('/x-admin/wali-kelas', [WaliKelasController::class, 'index'])->name('admin.wali-kelas.index');
  Route::get('/x-admin/wali-kelas/{guru}/edit', [WaliKelasController::class, 'edit'])->name('admin.wali-kelas.edit');
  Route::put('/x-admin/wali-kelas/{guru}', [WaliKelasController::class, 'update'])->name('admin.wali-kelas.update');
  Route::delete('/x-admin/wali-kelas/{guru}', [WaliKelasController::class, 'destroy'])->name('admin.wali-kelas.destroy');

  // Admin Guru Management
  Route::get('/x-admin/guru', [AdminGuruController::class, 'index'])->name('admin.guru.index');
  Route::get('/x-admin/guru/create', [AdminGuruController::class, 'create'])->name('admin.guru.create');
  Route::post('/x-admin/guru', [AdminGuruController::class, 'store'])->name('admin.guru.store');
  Route::get('/x-admin/guru/{guru}/edit', [AdminGuruController::class, 'edit'])->name('admin.guru.edit');
  Route::put('/x-admin/guru/{guru}', [AdminGuruController::class, 'update'])->name('admin.guru.update');
  Route::delete('/x-admin/guru/{guru}', [AdminGuruController::class, 'destroy'])->name('admin.guru.destroy');

  // Admin Rekap
  Route::get('/x-admin/rekap-absensi', [AdminRekapController::class, 'index'])->name('admin.rekap.index');
  Route::get('/x-admin/rekap-absensi/export', [AdminRekapController::class, 'export'])->name('admin.rekap.export');

  Route::get('/x-admin/laporan/export', [AdminExportController::class, 'summary'])->name('admin.dashboard.export');

  Route::view('/x-admin/tambah-pengguna', 'admin.users.quick')->name('admin.users.quick');
  Route::get('/x-admin/orang-tua/create', [AdminParentController::class, 'create'])->name('admin.parents.create');
  Route::post('/x-admin/orang-tua', [AdminParentController::class, 'store'])->name('admin.parents.store');

  // Admin Students Management
  Route::get('/x-admin/siswa', [AdminStudentController::class, 'index'])->name('admin.students.index');
  Route::get('/x-admin/siswa/create', [AdminStudentController::class, 'create'])->name('admin.students.create');
  Route::post('/x-admin/siswa', [AdminStudentController::class, 'store'])->name('admin.students.store');
  Route::get('/x-admin/siswa/{student}/edit', [AdminStudentController::class, 'edit'])->name('admin.students.edit');
  Route::put('/x-admin/siswa/{student}', [AdminStudentController::class, 'update'])->name('admin.students.update');
  Route::delete('/x-admin/siswa/{student}', [AdminStudentController::class, 'destroy'])->name('admin.students.destroy');
});

require __DIR__ . '/settings.php';
