<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
  /**
   * Show announcements for all users (from database)
   */
  public function index(Request $request)
  {
    $user = $this->getAuthUser();

    // Get filter category from request
    $category = $request->get('category', 'all');

    // Build query for active announcements
    $query = Announcement::active()->recent();

    // Filter by category if specified
    if ($category !== 'all' && !empty($category)) {
      $query->where('category', $category);
    }

    // Get announcements from database
    $announcements = $query->get();

    // Calculate unread count for the user
    $unreadCount = 0;
    if ($user) {
      $unreadCount = Announcement::active()
        ->whereDoesntHave('readBy', function ($q) use ($user) {
          $q->where('user_id', $user->id);
        })
        ->count();
    }

    return view('announcements.index', [
      'announcements' => $announcements,
      'unreadCount' => $unreadCount,
      'user' => $user,
      'currentCategory' => $category,
    ]);
  }

  /**
   * Show specific announcement (from database)
   */
  public function show($id)
  {
    $user = $this->getAuthUser();

    // Find announcement by ID from database
    $announcement = Announcement::active()->find($id);

    if (!$announcement) {
      abort(404, 'Pengumuman tidak ditemukan');
    }

    // Mark as read by current user
    if ($user) {
      $announcement->markAsReadBy($user);
    }

    return view('announcements.show', [
      'announcement' => $announcement,
      'user' => $user,
    ]);
  }

  /**
   * Admin: List all announcements
   */
  public function adminIndex(Request $request)
  {
    $search = $request->get('search', '');
    $category = $request->get('category', 'all');

    $query = Announcement::recent();

    // Apply search filter
    if (!empty($search)) {
      $query->where(function ($q) use ($search) {
        $q->where('title', 'like', "%{$search}%")
          ->orWhere('content', 'like', "%{$search}%");
      });
    }

    // Apply category filter
    if ($category !== 'all' && !empty($category)) {
      $query->where('category', $category);
    }

    $announcements = $query->paginate(10)->withQueryString();

    return view('admin.announcements.index', compact('announcements', 'search', 'category'));
  }

  /**
   * Admin: Show create form
   */
  public function create()
  {
    return view('admin.announcements.create');
  }

  /**
   * Admin: Store new announcement
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'content' => ['required', 'string'],
      'category' => ['required', 'string', 'in:akademik,umum,kegiatan'],
      'priority' => ['required', 'string', 'in:high,medium,low'],
      'date' => ['required', 'date'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    $announcement = Announcement::create([
      'title' => $validated['title'],
      'content' => $validated['content'],
      'category' => $validated['category'],
      'priority' => $validated['priority'],
      'date' => $validated['date'],
      'author' => Auth::guard('admin')->user()->name,
      'is_active' => $validated['is_active'] ?? true,
    ]);

    return redirect()->route('admin.announcements.index')
      ->with('success', 'Pengumuman berhasil dibuat!');
  }

  /**
   * Admin: Show edit form
   */
  public function edit($id)
  {
    $announcement = Announcement::findOrFail($id);
    return view('admin.announcements.edit', compact('announcement'));
  }

  /**
   * Admin: Update announcement
   */
  public function update(Request $request, $id)
  {
    $announcement = Announcement::findOrFail($id);

    $validated = $request->validate([
      
      'title' => ['required', 'string', 'max:255'],
      'content' => ['required', 'string'],
      'category' => ['required', 'string', 'in:akademik,umum,kegiatan'],
      'priority' => ['required', 'string', 'in:high,medium,low'],
      'date' => ['required', 'date'],
      'is_active' => ['nullable', 'boolean'],
    ]);

    $announcement->update([
      'title' => $validated['title'],
      'content' => $validated['content'],
      'category' => $validated['category'],
      'priority' => $validated['priority'],
      'date' => $validated['date'],
      'is_active' => $validated['is_active'] ?? true,
    ]);

    return redirect()->route('admin.announcements.index')
      ->with('success', 'Pengumuman berhasil diperbarui!');
  }

  /**
   * Admin: Delete announcement
   */
  public function destroy($id)
  {
    $announcement = Announcement::findOrFail($id);
    $announcement->delete();

    return redirect()->route('admin.announcements.index')
      ->with('success', 'Pengumuman berhasil dihapus!');
  }

  private function getAuthUser()
  {
    foreach (['web', 'guru', 'admin', 'ortu'] as $guard) {
      if (Auth::guard($guard)->check()) {
        return Auth::guard($guard)->user();
      }
    }
    return null;
  }
}
