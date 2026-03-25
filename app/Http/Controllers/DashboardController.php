<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
  /**
   * Show dashboard for Murid (Student)
   */
  public function murid()
  {
    $user = Auth::user();

    // Get recent attendances for the student
    $recentAttendances = Attendance::where('user_id', $user->id)
      ->orderBy('date', 'desc')
      ->take(5)
      ->get();

    // Calculate statistics for current month
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
    $user = Auth::user();
    $isWaliKelas = $user->kelas_wali !== null;

    if ($isWaliKelas) {
      // Wali Kelas Dashboard - filter students by kelas_wali and jurusan_wali
      $query = User::where('role', User::ROLE_MURID)
        ->where('class', $user->kelas_wali);
      if ($user->jurusan_wali) {
        $query->where('jurusan', $user->jurusan_wali);
      }
      $students = $query->orderBy('name')->get();
      $totalStudents = $students->count();

      // Today's attendance for wali class students only
      $studentIds = $students->pluck('id');
      $todayAttendances = Attendance::where('date', today())
        ->whereIn('user_id', $studentIds)
        ->with('user')
        ->orderBy('check_in', 'desc')
        ->get();

      $presentToday = $todayAttendances->whereNotNull('check_in')->count();
      $absentToday = $totalStudents - $presentToday;

      // Monthly stats for wali class
      $monthlyStats = $this->getWaliMonthlyStats($studentIds);

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
          'isWaliKelas' => true,
          'kelasWali' => $user->kelas_wali,
          'jurusanWali' => $user->jurusan_wali,
        ]
      ]);
    } else {
      // Regular Guru Dashboard - all students
      $students = User::where('role', User::ROLE_MURID)->get();
      $totalStudents = $students->count();

      $todayAttendances = Attendance::where('date', today())
        ->with('user')
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
  }

  /**
   * Show dashboard for Orang Tua (Parent)
   */
  public function orangTua()
  {
    $user = Auth::user();

    // Get children of this parent
    $children = User::where('parent_id', $user->id)
      ->where('role', User::ROLE_MURID)
      ->get();

    // If parent has children, show first child's data
    $child = $children->first();

    if ($child) {
      // Get child's recent attendances
      $childAttendances = Attendance::where('user_id', $child->id)
        ->orderBy('date', 'desc')
        ->take(5)
        ->get();

      // Calculate child's statistics
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

    // If no children found, show empty state
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

  /**
   * Get monthly statistics for Guru dashboard (all students)
   */
  private function getGuruMonthlyStats(): array
  {
    $startOfMonth = now()->startOfMonth();
    $endOfMonth = now()->endOfMonth();

    $totalRecords = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])->count();

    $presentRecords = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])
      ->whereNotNull('check_in')
      ->count();

    $average = $totalRecords > 0 ? round(($presentRecords / $totalRecords) * 100) : 0;

    return [
      'average' => $average,
      'totalRecords' => $totalRecords,
    ];
  }

  /**
   * Get monthly statistics for Wali Kelas (specific class students)
   */
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

    return [
      'average' => $average,
      'totalRecords' => $totalRecords,
    ];
  }

  /**
   * Show default dashboard
   */
  public function index()
  {
    $user = Auth::user();

    // Redirect based on role
    if ($user->isMurid()) {
      return redirect()->route('dashboard.murid');
    } elseif ($user->isWaliKelas()) {
      return redirect()->route('wali-kelas.index');
    } elseif ($user->isGuru()) {
      return redirect()->route('dashboard.guru');
    } elseif ($user->isOrangTua()) {
      return redirect()->route('dashboard.orangtua');
    }

    return view('dashboard', ['user' => $user]);
  }
}
