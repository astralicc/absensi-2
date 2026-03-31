<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceManageController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::guard('guru')->user();
    $date = $request->get('date', today()->format('Y-m-d'));

    $query = Siswa::orderBy('name');

    if ($user->kelas_wali) {
      $query->where('class', $user->kelas_wali);
      if ($user->jurusan_wali) {
        $query->where('jurusan', $user->jurusan_wali);
      }
    }

    $students = $query->get();

    $attendances = Attendance::where('date', $date)
      ->pluck('check_in', 'user_id')
      ->toArray();

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

  public function markAttendance(Request $request)
  {
    $request->validate([
      'user_id' => 'required|exists:siswa,id',
      'date' => 'required|date',
      'status' => 'required|in:present,absent',
    ]);

    $userId = $request->user_id;
    $date = $request->date;
    $status = $request->status;

    if ($status === 'present') {
      Attendance::updateOrCreate(
        ['user_id' => $userId, 'date' => $date],
        ['check_in' => now()]
      );
    } else {
      Attendance::where('user_id', $userId)
        ->where('date', $date)
        ->delete();
    }

    return redirect()->back()->with('success', 'Kehadiran berhasil diperbarui');
  }

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
          ['user_id' => $userId, 'date' => $date],
          ['check_in' => now()]
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
