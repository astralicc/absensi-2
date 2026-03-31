<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
  /**
   * Show reports page for Guru (Teacher)
   */
  public function index(Request $request)
  {
    $user = Auth::guard('guru')->user();

    // Get filter parameters
    $month = $request->get('month', now()->month);
    $year = $request->get('year', now()->year);

    // Get all students
    $students = Siswa::all();

    // Calculate attendance statistics for each student
    $studentReports = [];
    foreach ($students as $student) {
      $totalDays = Attendance::where('user_id', $student->id)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->count();

      $presentDays = Attendance::where('user_id', $student->id)
        ->whereMonth('date', $month)
        ->whereYear('date', $year)
        ->whereNotNull('check_in')
        ->count();

      $absentDays = $totalDays - $presentDays;
      $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

      $studentReports[] = [
        'student' => $student,
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'absentDays' => $absentDays,
        'attendanceRate' => $attendanceRate,
      ];
    }

    // Sort by attendance rate (ascending - lowest first)
    usort($studentReports, function ($a, $b) {
      return $a['attendanceRate'] <=> $b['attendanceRate'];
    });

    // Calculate overall statistics
    $totalStudents = $students->count();
    $totalAttendanceRecords = array_sum(array_column($studentReports, 'totalDays'));
    $totalPresentRecords = array_sum(array_column($studentReports, 'presentDays'));
    $overallAttendanceRate = $totalAttendanceRecords > 0
      ? round(($totalPresentRecords / $totalAttendanceRecords) * 100)
      : 0;

    // Get daily statistics for the month
    $dailyStats = [];
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    for ($day = 1; $day <= $daysInMonth; $day++) {
      $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
      $totalAttendances = Attendance::where('date', $date)->count();
      $presentAttendances = Attendance::where('date', $date)
        ->whereNotNull('check_in')
        ->count();

      $dailyStats[$day] = [
        'date' => $date,
        'total' => $totalAttendances,
        'present' => $presentAttendances,
        'absent' => $totalAttendances - $presentAttendances,
        'rate' => $totalAttendances > 0 ? round(($presentAttendances / $totalAttendances) * 100) : 0,
      ];
    }

    return view('reports.index', [
      'studentReports' => $studentReports,
      'dailyStats' => $dailyStats,
      'overallStats' => [
        'totalStudents' => $totalStudents,
        'totalAttendanceRecords' => $totalAttendanceRecords,
        'totalPresentRecords' => $totalPresentRecords,
        'overallAttendanceRate' => $overallAttendanceRate,
      ],
      'filters' => [
        'month' => $month,
        'year' => $year,
      ],
      'user' => $user,
    ]);
  }

  /**
   * Export report to PDF/Excel
   */
  public function export(Request $request)
  {

  {
    $month = $request->month;
    $year = $request->year;

    return Excel::download(new AbsensiExport($month, $year), 'laporan-absensi.xlsx');
  }

  }
}