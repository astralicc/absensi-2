<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  /**
   * Show dashboard for Murid (Student)
   */
  public function murid()
  {
    $user = Auth::guard('web')->user();

    $recentAttendances = Attendance::where('user_id', $user->id)
      ->orderBy('date', 'desc')
      ->take(5)
      ->get();

    $totalDays = Attendance::where('user_id', $user->id)
      ->whereMonth('date', now()->month)
      ->count();

    $presentDays = Attendance::where('user_id', $user->id)
      ->whereMonth('date', now()->month)
      ->whereNotNull('check_in')
      ->count();

    $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

    return view('dashboard', [
      'user' => $user,
      'recentAttendances' => $recentAttendances,
      'stats' => [
        'attendanceRate' => $attendanceRate,
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
      ]
    ]);
  }

  /**
   * Show dashboard for Guru (Teacher)
   */
  public function guru()
  {
    $user = Auth::guard('guru')->user();
    
    if ($user->isWaliKelas()) {
      return redirect()->route('wali-kelas.index');
    }

    $students = Siswa::all();
    $totalStudents = $students->count();

    $todayAttendances = Attendance::where('date', today())
      ->with('siswa')
      ->orderBy('check_in', 'desc')
      ->get();

    $presentToday = $todayAttendances->whereNotNull('check_in')->count();
    $absentToday = $totalStudents - $presentToday;

    $monthlyStats = $this->getGuruMonthlyStats();

    return view('dashboard', [
      'user' => $user,
      'todayAttendances' => $todayAttendances,
      'students' => $students,
      'stats' => [
        'totalStudents' => $totalStudents,
        'presentToday' => $presentToday,
        'absentToday' => $absentToday,
        'monthlyAverage' => $monthlyStats['average'],
        'totalAttendanceRecords' => $monthlyStats['totalRecords'],
        'isWaliKelas' => false,
      ]
    ]);
  }

  /**
   * Show dashboard for Orang Tua (Parent)
   */
  public function orangTua()
  {
    $user = Auth::guard('ortu')->user();

    $children = Siswa::where('parent_id', $user->id)->get();
    $child = $children->first();

    if ($child) {
      $childAttendances = Attendance::where('user_id', $child->id)
        ->orderBy('date', 'desc')
        ->take(5)
        ->get();

      $totalDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', now()->month)
        ->count();

      $presentDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', now()->month)
        ->whereNotNull('check_in')
        ->count();

      $lateDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', now()->month)
        ->whereTime('check_in', '>', '07:30:00')
        ->count();

      $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

      return view('dashboard', [
        'user' => $user,
        'child' => $child,
        'children' => $children,
        'childAttendances' => $childAttendances,
        'stats' => [
          'attendanceRate' => $attendanceRate,
          'totalDays' => $totalDays,
          'lateDays' => $lateDays,
          'presentDays' => $presentDays,
        ]
      ]);
    }

    return view('dashboard', [
      'user' => $user,
      'child' => null,
      'children' => collect(),
      'childAttendances' => collect(),
      'stats' => [
        'attendanceRate' => 0,
        'totalDays' => 0,
        'lateDays' => 0,
        'presentDays' => 0,
      ]
    ]);
  }

  private function getGuruMonthlyStats(): array
  {
    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();

    $totalRecords = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])->count();
    $presentRecords = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])
      ->whereNotNull('check_in')
      ->count();

    $average = $totalRecords > 0 ? round(($presentRecords / $totalRecords) * 100) : 0;

    return ['average' => $average, 'totalRecords' => $totalRecords];
  }

  private function getWaliMonthlyStats($studentIds): array
  {
    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();

    $totalRecords = Attendance::whereIn('user_id', $studentIds)
      ->whereBetween('date', [$startOfMonth, $endOfMonth])
      ->count();

    $presentRecords = Attendance::whereIn('user_id', $studentIds)
      ->whereBetween('date', [$startOfMonth, $endOfMonth])
      ->whereNotNull('check_in')
      ->count();

    $average = $totalRecords > 0 ? round(($presentRecords / $totalRecords) * 100) : 0;

    return ['average' => $average, 'totalRecords' => $totalRecords];
  }

  /**
   * Show default dashboard - redirect based on guard
   */
  public function index()
  {
    if (Auth::guard('web')->check()) {
      return redirect()->route('dashboard.murid');
    } elseif (Auth::guard('guru')->check()) {
      $guru = Auth::guard('guru')->user();
      if ($guru->isWaliKelas()) {
        return redirect()->route('wali-kelas.index');
      }
      return redirect()->route('dashboard.guru');
    } elseif (Auth::guard('ortu')->check()) {
      return redirect()->route('dashboard.orangtua');
    } elseif (Auth::guard('admin')->check()) {
      return redirect()->route('admin.dashboard');
    }

    return redirect()->route('login');
  }
}
