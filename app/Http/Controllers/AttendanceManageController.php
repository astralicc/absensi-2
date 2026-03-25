<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceManageController extends Controller
{
  /**
   * Show attendance management page for Guru (Teacher)
   */
  public function index(Request $request)
  {
    $user = Auth::user();
    $date = $request->get('date', today()->format('Y-m-d'));

    // Get students filtered by teacher's kelas_wali
    $query = User::where('role', User::ROLE_MURID)
      ->orderBy('name');

    // If teacher has kelas_wali assigned, filter by that class
    if ($user->kelas_wali) {
      $query->where('class', $user->kelas_wali);
      
      // If teacher also has jurusan_wali, filter by that too
      if ($user->jurusan_wali) {
        $query->where('jurusan', $user->jurusan_wali);
      }
    }

    $students = $query->get();

    // Get attendance records for selected date
    $attendances = Attendance::where('date', $date)
      ->pluck('check_in', 'user_id')
      ->toArray();

    // Calculate statistics
    $totalStudents = $students->count();
    $presentCount = count(array_filter($attendances));
    $absentCount = $totalStudents - $presentCount;

    return view('attendance.manage', [
      'students' => $students,
      'attendances' => $attendances,
      'date' => $date,
      'stats' => [
        'totalStudents' => $totalStudents,
        'presentCount' => $presentCount,
        'absentCount' => $absentCount,
      ],
      'user' => $user,
    ]);
  }

  /**
   * Mark student attendance
   */
  public function markAttendance(Request $request)
  {
    $request->validate([
      'user_id' => 'required|exists:users,id',
      'date' => 'required|date',
      'status' => 'required|in:present,absent',
    ]);

    $userId = $request->user_id;
    $date = $request->date;
    $status = $request->status;

    if ($status === 'present') {
      // Mark as present (check in)
      Attendance::updateOrCreate(
        [
          'user_id' => $userId,
          'date' => $date,
        ],
        [
          'check_in' => now(),
        ]
      );
    } else {
      // Mark as absent (remove check_in)
      Attendance::where('user_id', $userId)
        ->where('date', $date)
        ->delete();
    }

    return redirect()->back()->with('success', 'Kehadiran berhasil diperbarui');
  }

  /**
   * Bulk mark attendance
   */
  public function bulkMarkAttendance(Request $request)
  {
    $request->validate([
      'date' => 'required|date',
      'attendances' => 'required|array',
    ]);

    $date = $request->date;
    $attendances = $request->attendances;

    foreach ($attendances as $userId => $status) {
      if ($status === 'present') {
        Attendance::updateOrCreate(
          [
            'user_id' => $userId,
            'date' => $date,
          ],
          [
            'check_in' => now(),
          ]
        );
      } else {
        Attendance::where('user_id', $userId)
          ->where('date', $date)
          ->delete();
      }
    }

    return redirect()->back()->with('success', 'Kehadiran massal berhasil diperbarui');
  }
}
