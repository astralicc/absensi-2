<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Announcement extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'content',
    'category',
    'priority',
    'author',
    'date',
    'is_active',
  ];

  protected $casts = [
    'date' => 'date',
    'is_active' => 'boolean',
  ];

  /**
   * Users who have read this announcement (direct query - no FK to users table)
   */
  public function readBy()
  {
    return $this->hasMany(AnnouncementRead::class);
  }

  /**
   * Check if a specific user has read this announcement
   */
  public function isReadBy($user): bool
  {
    return DB::table('announcement_reads')
      ->where('announcement_id', $this->id)
      ->where('user_id', $user->id)
      ->exists();
  }

  /**
   * Mark as read by a user
   */
  public function markAsReadBy($user): void
  {
    if (!$this->isReadBy($user)) {
      DB::table('announcement_reads')->insert([
        'user_id' => $user->id,
        'announcement_id' => $this->id,
        'read_at' => now(),
        'created_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }

  /**
   * Scope for active announcements
   */
  public function scopeActive($query)
  {
    return $query->where('is_active', true);
  }

  /**
   * Scope for recent announcements
   */
  public function scopeRecent($query)
  {
    return $query->orderBy('date', 'desc');
  }
}
