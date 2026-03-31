<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentListController extends Controller
{
  public function index(Request $request)
  {
    // Works for both guru guard and admin guard
    $user = Auth::guard('guru')->user();

    $search = $request->get('search');
    $sortBy = $request->get('sort_by', 'name');
    $sortOrder = $request->get('sort_order', 'asc');

    $query = Siswa::query();

    if ($user && $user->kelas_wali) {
      $query->where('class', $user->kelas_wali);
      if ($user->jurusan_wali) {
        $query->where('jurusan', $user->jurusan_wali);
      }
    }

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('id', 'like', "%{$search}%")
          ->orWhere('nisn', 'like', "%{$search}%");
      });
    }

    $validSortColumns = ['name', 'id', 'nisn'];
    if (in_array($sortBy, $validSortColumns)) {
      $query->orderBy($sortBy, $sortOrder);
    } else {
      $query->orderBy('name', 'asc');
    }

    $students = $query->paginate(20);

    $studentStats = [];
    foreach ($students as $student) {
      $totalDays = Attendance::where('user_id', $student->id)
        ->whereMonth('date', now()->month)
        ->count();

      $presentDays = Attendance::where('user_id', $student->id)
        ->whereMonth('date', now()->month)
        ->whereNotNull('check_in')
        ->count();

      $attendanceRate = $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0;

      $studentStats[$student->id] = [
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'attendanceRate' => $attendanceRate,
      ];
    }

    return view('students.index', [
      'students' => $students,
      'studentStats' => $studentStats,
      'filters' => [
        'search' => $search,
        'sort_by' => $sortBy,
        'sort_order' => $sortOrder,
      ],
      'user' => $user,
    ]);
  }

  public function show($id)
  {
    $user = Auth::guard('guru')->user();
    $student = Siswa::findOrFail($id);

    $attendances = Attendance::where('user_id', $student->id)
      ->orderBy('date', 'desc')
      ->take(30)
      ->get();

    $monthlyStats = [];
    for ($i = 1; $i <= 12; $i++) {
      $totalDays = Attendance::where('user_id', $student->id)
        ->whereMonth('date', $i)
        ->whereYear('date', now()->year)
        ->count();

      $presentDays = Attendance::where('user_id', $student->id)
        ->whereMonth('date', $i)
        ->whereYear('date', now()->year)
        ->whereNotNull('check_in')
        ->count();

      $monthlyStats[$i] = [
        'totalDays' => $totalDays,
        'presentDays' => $presentDays,
        'attendanceRate' => $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0,
      ];
    }

    return view('students.show', [
      'student' => $student,
      'attendances' => $attendances,
      'monthlyStats' => $monthlyStats,
      'user' => $user,
    ]);
  }
}
