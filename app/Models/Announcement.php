<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
   * Users who have read this announcement
   */
  public function readBy(): BelongsToMany
  {
    return $this->belongsToMany(User::class, 'announcement_reads')
      ->withPivot('read_at')
      ->withTimestamps();
  }

  /**
   * Check if a specific user has read this announcement
   */
  public function isReadBy(User $user): bool
  {
    return $this->readBy()->where('user_id', $user->id)->exists();
  }

  /**
   * Mark as read by a user
   */
  public function markAsReadBy(User $user): void
  {
    if (!$this->isReadBy($user)) {
      $this->readBy()->attach($user->id, ['read_at' => now()]);
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
