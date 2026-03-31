<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable
{
    use Notifiable;

    protected $table = 'guru';

    protected $fillable = [
        'name',
        'email',
        'password',
        'nip',
        'phone',
        'address',
        'gender',
        'birth_date',
        'kelas_wali',
        'jurusan_wali',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /**
     * Check if guru is Wali Kelas
     */
    public function isWaliKelas(): bool
    {
        return !empty($this->kelas_wali);
    }

    /**
     * Announcements read by this guru
     */
    public function readAnnouncements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_reads', 'user_id', 'announcement_id')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    /**
     * Get unread announcements count
     */
    public function unreadAnnouncementsCount(): int
    {
        return Announcement::active()
            ->whereNotIn('id', function ($query) {
                $query->select('announcement_id')
                    ->from('announcement_reads')
                    ->where('user_id', $this->id);
            })
            ->count();
    }
}
