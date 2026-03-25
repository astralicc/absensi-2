<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildDataController extends Controller
{
  /**
   * Show child data for Orang Tua (Parent)
   */
  public function index()
  {
    $user = Auth::user();

    // Get all children of this parent
    $children = User::where('parent_id', $user->id)
      ->where('role', User::ROLE_MURID)
      ->get();

    // Calculate statistics for each child
    $childrenStats = [];
    foreach ($children as $child) {
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

      // Get today's attendance
      $todayAttendance = Attendance::where('user_id', $child->id)
        ->where('date', today())
        ->first();

      $childrenStats[$child->id] = [
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'lateDays' => $lateDays,
        'attendanceRate' => $attendanceRate,
        'todayStatus' => $todayAttendance ? ($todayAttendance->check_in ? 'Hadir' : 'Tidak Hadir') : 'Belum Absen',
        'todayCheckIn' => $todayAttendance && $todayAttendance->check_in ? $todayAttendance->check_in->format('H:i') : null,
      ];
    }

    return view('children.data', [
      'children' => $children,
      'childrenStats' => $childrenStats,
      'user' => $user,
    ]);
  }

  /**
   * Show detail for specific child
   */
  public function show($id)
  {
    $user = Auth::user();

    // Verify this child belongs to the parent
    $child = User::where('id', $id)
      ->where('parent_id', $user->id)
      ->where('role', User::ROLE_MURID)
      ->firstOrFail();

    // Get monthly statistics
    $monthlyStats = [];
    for ($i = 1; $i <= 12; $i++) {
      $totalDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', $i)
        ->whereYear('date', now()->year)
        ->count();

      $presentDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', $i)
        ->whereYear('date', now()->year)
        ->whereNotNull('check_in')
        ->count();

      $lateDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', $i)
        ->whereYear('date', now()->year)
        ->whereTime('check_in', '>', '07:30:00')
        ->count();

      $monthlyStats[$i] = [
        'month' => $i,
        'monthName' => $this->getMonthName($i),
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'lateDays' => $lateDays,
        'attendanceRate' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0,
      ];
    }

    // Get recent attendance
    $recentAttendances = Attendance::where('user_id', $child->id)
      ->orderBy('date', 'desc')
      ->take(10)
      ->get();

    return view('children.show', [
      'child' => $child,
      'monthlyStats' => $monthlyStats,
      'recentAttendances' => $recentAttendances,
      'user' => $user,
    ]);
  }

  /**
   * Get month name in Indonesian
   */
  private function getMonthName($month)
  {
    $months = [
      1 => 'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10 => 'Oktober',
      11 => 'November',
      12 => 'Desember',
    ];

    return $months[$month] ?? '';
  }
}
