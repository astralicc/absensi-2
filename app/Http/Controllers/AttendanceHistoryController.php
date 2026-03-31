<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceHistoryController extends Controller
{
  /**
   * Show attendance history for Murid (Student)
   */
  public function index(Request $request)
  {
    $user = Auth::guard('web')->user();

    // Get filter parameters
    $month = $request->get('month', now()->month);
    $year = $request->get('year', now()->year);

    // Get attendances with filters
    $attendances = Attendance::where('user_id', $user->id)
      ->whereMonth('date', $month)
      ->whereYear('date', $year)
      ->orderBy('date', 'desc')
      ->get();

    // Calculate statistics
    $totalDays = $attendances->count();
    $presentDays = $attendances->whereNotNull('check_in')->count();
    $absentDays = $totalDays - $presentDays;
    $lateDays = $attendances->filter(function ($attendance) {
      return $attendance->check_in && $attendance->check_in->format('H:i:s') > '07:30:00';
    })->count();

    $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

    // Get available months for filter (SQLite compatible)
    $availableMonths = DB::table('attendances')
      ->selectRaw('DISTINCT MONTH(date) as month, YEAR(date) as year')
      ->where('user_id', 12345)
      ->orderByDesc('year')
      ->orderByDesc('month')
      ->limit(12)
      ->get();

    return view('attendance.history', [
      'user' => $user,
      'attendances' => $attendances,
      'stats' => [
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'absentDays' => $absentDays,
        'lateDays' => $lateDays,
        'attendanceRate' => $attendanceRate,
      ],
      'filters' => [
        'month' => $month,
        'year' => $year,
      ],
      'availableMonths' => $availableMonths,
    ]);
  }



  /**
   * Show report attendance issue page for Murid (Student)
   */
  // Removed invalid trait use


  public function report()
  {
    $settings = \App\Http\Controllers\AdminSettingController::getPublicSettings();

    return view('attendance.report', [
      'user' => Auth::guard('web')->user(),
      'adminWhatsapp' => $settings['admin_whatsapp'] ?? '081234567890',
      'adminEmail' => $settings['admin_email'] ?? 'admin@smkn12jakarta.sch.id',
      'unreadCount' => 0,
    ]);
  }
}
