<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentListController extends Controller
{
  /**
   * Show student list for Guru (Teacher)
   */
  public function index(Request $request)
  {
    $user = Auth::user();

    // Get filter parameters
    $search = $request->get('search');
    $sortBy = $request->get('sort_by', 'name');
    $sortOrder = $request->get('sort_order', 'asc');

    // Query students
    $query = User::where('role', User::ROLE_MURID);

    // If user is a guru with wali kelas assignment, filter by their class and major
    if ($user->role === User::ROLE_GURU && $user->kelas_wali) {
      $query->where('class', $user->kelas_wali);
      
      // If guru has jurisdiction assignment, filter by jurisdiction
      if ($user->jurusan_wali) {
        $query->where('jurusan', $user->jurusan_wali);
      }
    }

    // Apply search filter
    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('id', 'like', "%{$search}%")
          ->orWhere('nisn', 'like', "%{$search}%");
      });
    }

    // Apply sorting - only allow valid columns
    $validSortColumns = ['name', 'id', 'nisn'];
    if (in_array($sortBy, $validSortColumns)) {
      $query->orderBy($sortBy, $sortOrder);
    } else {
      $query->orderBy('name', 'asc');
    }

    // Get students with pagination
    $students = $query->paginate(20);

    // Calculate attendance statistics for each student
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

  /**
   * Show student detail
   */
  public function show($id)
  {
    $user = Auth::user();
    $student = User::where('role', User::ROLE_MURID)
      ->where('id', $id)
      ->firstOrFail();

    // Get attendance history
    $attendances = Attendance::where('user_id', $student->id)
      ->orderBy('date', 'desc')
      ->take(30)
      ->get();

    // Calculate monthly statistics
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
