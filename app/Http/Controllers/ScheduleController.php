<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;
use App\Models\Announcement;

class ScheduleController extends Controller
{
  /**
   * Show class schedule for Murid (Student)
   */
  public function index()
  {
    $user = Auth::guard('web')->user();

    // Get schedule data from database
    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
    $schedule = [];

    foreach ($days as $day) {
      $daySchedules = Schedule::forDay($day)->get();

      if ($daySchedules->isEmpty()) {
        $schedule[$day] = [];
      } else {
        $schedule[$day] = $daySchedules->map(function ($item) {
          return [
            'time' => $item->time_range,
            'subject' => $item->subject,
            'teacher' => $item->teacher,
            'room' => $item->room,
          ];
        })->toArray();
      }
    }

    $today = now()->locale('id')->dayName;

    // Unread announcements count
    $unreadCount = 0;
    if ($user) {
      $unreadCount = Announcement::active()
        ->whereDoesntHave('readBy', function ($q) use ($user) {
          $q->where('user_id', $user->id);
        })
        ->count();
    }

    return view('schedule.index', [
      'schedule' => $schedule,
      'today' => $today,
      'user' => $user,
      'unreadCount' => $unreadCount,
    ]);
  }

  /**
   * Show manage schedule page for Guru (Teacher)
   */
  public function manage(Request $request)
  {
    $day = $request->get('day', 'all');
    $search = $request->get('search', '');

    $query = Schedule::query();

    if ($day !== 'all') {
      $query->where('day', $day);
    }

    if ($search) {
      $query->where(function ($q) use ($search) {
        $q->where('subject', 'like', "%{$search}%")
          ->orWhere('teacher', 'like', "%{$search}%");
      });
    }

    $schedules = $query->orderBy('day')->orderBy('start_time')->paginate(10);

    // Badge count for "Pengumuman" menu (same logic as AnnouncementController)
    $unreadCount = 0;
    $user = Auth::guard('guru')->user();
    if ($user) {
      $unreadCount = Announcement::active()
        ->whereDoesntHave('readBy', function ($q) use ($user) {
          $q->where('user_id', $user->id);
        })
        ->count();
    }

    return view('schedule.manage', [
      'user' => $user,
      'schedules' => $schedules,
      'day' => $day,
      'search' => $search,
      'unreadCount' => $unreadCount,
    ]);
  }

  /**
   * Show all schedules (for admin/teacher)
   */
  public function all()
  {
    $schedules = Schedule::orderBy('day')->orderBy('start_time')->get();

    return view('schedule.all', [
      'schedules' => $schedules,
    ]);
  }

  /**
   * Show form to create new schedule
   */
  public function create()
  {
    return view('schedule.create');
  }

  /**
   * Store new schedule
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
      'subject' => 'required|string|max:255',
      'teacher' => 'required|string|max:255',
      'room' => 'required|string|max:255',
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i|after:start_time',
      'class' => 'nullable|string|max:50',
    ]);

    Schedule::create($validated);

    return redirect()->route('schedule.manage')
      ->with('success', 'Jadwal berhasil ditambahkan!');
  }

  /**
   * Show form to edit schedule
   */
  public function edit(Schedule $schedule)
  {
    return view('schedule.edit', [
      'schedule' => $schedule,
    ]);
  }

  /**
   * Update schedule
   */
  public function update(Request $request, Schedule $schedule)
  {
    $validated = $request->validate([
      'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
      'subject' => 'required|string|max:255',
      'teacher' => 'required|string|max:255',
      'room' => 'required|string|max:255',
      'start_time' => 'required|date_format:H:i',
      'end_time' => 'required|date_format:H:i|after:start_time',
      'class' => 'nullable|string|max:50',
    ]);

    $schedule->update($validated);

    return redirect()->route('schedule.manage')
      ->with('success', 'Jadwal berhasil diperbarui!');
  }

  /**
   * Delete schedule
   */
  public function destroy(Schedule $schedule)
  {
    $schedule->delete();

    return redirect()->route('schedule.manage')
      ->with('success', 'Jadwal berhasil dihapus!');
  }
}
