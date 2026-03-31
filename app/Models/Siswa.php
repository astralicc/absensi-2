<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'siswa';

    /**
     * Class constants (enum)
     */
    public const CLASS_X = 'X';
    public const CLASS_XI = 'XI';
    public const CLASS_XII = 'XII';

    /**
     * Jurusan (Major) constants
     */
    public const JURUSAN_RPL = 'RPL';
    public const JURUSAN_BR = 'BR';
    public const JURUSAN_AKL = 'AKL';
    public const JURUSAN_MP = 'MP';

    public static function getClasses(): array
    {
        return [self::CLASS_X, self::CLASS_XI, self::CLASS_XII];
    }

    public static function getJurusans(): array
    {
        return [self::JURUSAN_RPL, self::JURUSAN_BR, self::JURUSAN_AKL, self::JURUSAN_MP];
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'nis',
        'nisn',
        'parent_id',
        'phone',
        'address',
        'class',
        'jurusan',
        'gender',
        'birth_date',
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
     * Get parent (orang tua)
     */
    public function parent()
    {
        return $this->belongsTo(OrangTua::class, 'parent_id');
    }

    /**
     * Get attendances
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    /**
     * Announcements read by this siswa
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
