<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildDataController extends Controller
{
  public function index()
  {
    $user = Auth::guard('ortu')->user();

    $children = Siswa::where('parent_id', $user->id)->get();

    $childrenStats = [];
    foreach ($children as $child) {
      $totalDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', now()->month)->count();
      $presentDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', now()->month)->whereNotNull('check_in')->count();
      $lateDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', now()->month)->whereTime('check_in', '>', '07:30:00')->count();
      $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

      $todayAttendance = Attendance::where('user_id', $child->id)
        ->where('date', today())->first();

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

  public function show($id)
  {
    $user = Auth::guard('ortu')->user();

    $child = Siswa::where('id', $id)
      ->where('parent_id', $user->id)
      ->firstOrFail();

    $monthlyStats = [];
    for ($i = 1; $i <= 12; $i++) {
      $totalDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', $i)->whereYear('date', now()->year)->count();
      $presentDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', $i)->whereYear('date', now()->year)->whereNotNull('check_in')->count();
      $lateDays = Attendance::where('user_id', $child->id)
        ->whereMonth('date', $i)->whereYear('date', now()->year)->whereTime('check_in', '>', '07:30:00')->count();

      $monthlyStats[$i] = [
        'month' => $i,
        'monthName' => $this->getMonthName($i),
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'lateDays' => $lateDays,
        'attendanceRate' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0,
      ];
    }

    $recentAttendances = Attendance::where('user_id', $child->id)
      ->orderBy('date', 'desc')->take(10)->get();

    return view('children.show', [
      'child' => $child,
      'monthlyStats' => $monthlyStats,
      'recentAttendances' => $recentAttendances,
      'user' => $user,
    ]);
  }

  private function getMonthName($month)
  {
    $months = [
      1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
      5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
      9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    return $months[$month] ?? '';
  }
}
