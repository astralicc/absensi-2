<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];



    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get unread announcements count for this admin
     */
    public function unreadAnnouncementsCount(): int
    {
        return \App\Models\Announcement::active()
            ->whereNotIn('id', function ($query) {
                $query->select('announcement_id')
                    ->from('announcement_reads')
                    ->where('user_id', $this->id);
            })
            ->count();
    }
}
