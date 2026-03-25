<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChildAttendanceController extends Controller
{
  /**
   * Show child attendance history for Orang Tua (Parent)
   */
  public function index(Request $request)
  {
    $user = Auth::user();

    // Get filter parameters
    $childId = $request->get('child_id');
    $month = $request->get('month', now()->month);
    $year = $request->get('year', now()->year);

    // Get all children of this parent
    $children = User::where('parent_id', $user->id)
      ->where('role', User::ROLE_MURID)
      ->get();

    // If no child selected, use first child
    if (!$childId && $children->count() > 0) {
      $childId = $children->first()->id;
    }

    $selectedChild = $children->where('id', $childId)->first();

    // Get attendance records
    $attendances = collect();
    if ($selectedChild) {
      $attendances = Attendance::where('user_id', $selectedChild->id)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->orderBy('date', 'desc')
        ->get();
    }

    // Calculate statistics
    $totalDays = $attendances->count();
    $presentDays = $attendances->whereNotNull('check_in')->count();
    $absentDays = $totalDays - $presentDays;
    $lateDays = $attendances->filter(function ($attendance) {
      return $attendance->check_in && $attendance->check_in->format('H:i:s') > '07:30:00';
    })->count();

    $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

    // Get available months for filter (SQLite compatible)
    $availableMonths = collect();
    if ($selectedChild) {
      $availableMonths = Attendance::where('user_id', $selectedChild->id)
        ->selectRaw("MONTH(date) as month, YEAR(date) as year")
        ->groupByRaw("YEAR(date), MONTH(date)")
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->limit(12)
        ->get();
    }

    return view('children.attendance', [
      'children' => $children,
      'selectedChild' => $selectedChild,
      'attendances' => $attendances,
      'stats' => [
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'absentDays' => $absentDays,
        'lateDays' => $lateDays,
        'attendanceRate' => $attendanceRate,
      ],
      'filters' => [
        'child_id' => $childId,
        'month' => $month,
        'year' => $year,
      ],
      'availableMonths' => $availableMonths,
      'user' => $user,
    ]);
  }

  /**
   * Show attendance calendar view
   */
  public function calendar(Request $request)
  {
    $user = Auth::user();

    $childId = $request->get('child_id');
    $month = $request->get('month', now()->month);
    $year = $request->get('year', now()->year);

    // Get all children
    $children = User::where('parent_id', $user->id)
      ->where('role', User::ROLE_MURID)
      ->get();

    if (!$childId && $children->count() > 0) {
      $childId = $children->first()->id;
    }

    $selectedChild = $children->where('id', $childId)->first();

    // Get attendance for calendar
    $attendances = collect();
    if ($selectedChild) {
      $attendances = Attendance::where('user_id', $selectedChild->id)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->get()
        ->keyBy(function ($attendance) {
          return $attendance->date->format('Y-m-d');
        });
    }

    // Generate calendar data
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstDayOfMonth = date('N', strtotime("{$year}-{$month}-01"));

    return view('children.calendar', [
      'children' => $children,
      'selectedChild' => $selectedChild,
      'attendances' => $attendances,
      'calendar' => [
        'month' => $month,
        'year' => $year,
        'daysInMonth' => $daysInMonth,
        'firstDayOfMonth' => $firstDayOfMonth,
      ],
      'filters' => [
        'child_id' => $childId,
        'month' => $month,
        'year' => $year,
      ],
      'user' => $user,
    ]);
  }
}
