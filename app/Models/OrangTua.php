<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class OrangTua extends Authenticatable
{
    use Notifiable;

    protected $table = 'orang_tua';

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_ortu',
        'phone',
        'address',
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
     * Get unread announcements count for this parent
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

    /**
     * Get children (siswa)
     */
    public function children()
    {
        return $this->hasMany(\App\Models\Siswa::class, 'parent_id');
    }
}
