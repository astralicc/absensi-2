<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * Role constants
     */
    public const ROLE_MURID = 'murid';
    public const ROLE_GURU = 'guru';
    public const ROLE_WALI_KELAS = 'wali_kelas';
    public const ROLE_ORANGTUA = 'orang_tua';
    public const ROLE_ADMIN = 'admin';

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

    /**
     * Get all available classes
     */
    public static function getClasses(): array
    {
        return [self::CLASS_X, self::CLASS_XI, self::CLASS_XII];
    }

    /**
     * Get all available majors
     */
    public static function getJurusans(): array
    {
        return [self::JURUSAN_RPL, self::JURUSAN_BR, self::JURUSAN_AKL, self::JURUSAN_MP];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'device_user_id',
        'parent_id',
        'nisn',

        'phone',
        'address',
        'class',
        'jurusan',
        'kelas_wali',
        'jurusan_wali',
        'gender',
        'birth_date',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'birth_date' => 'date',
        ];
    }

    /**
     * Check if user is Murid (Student)
     */
    public function isMurid(): bool
    {
        return $this->role === self::ROLE_MURID;
    }

    /**
     * Check if user is Guru (Teacher)
     */
    public function isGuru(): bool
    {
        return $this->role === self::ROLE_GURU;
    }

    /**
     * Check if user is Wali Kelas (guru + kelas_wali assigned)
     */
    public function isWaliKelas(): bool
    {
        return $this->isGuru() && !empty($this->kelas_wali);
    }

    /**
     * Check if user is Orang Tua (Parent)
     */
    public function isOrangTua(): bool
    {
        return $this->role === self::ROLE_ORANGTUA;
    }

    /**
     * Check if user is Admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get attendances for this user
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get parent (for murid)
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get children (for orang tua)
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Announcements read by this user
     */
    public function readAnnouncements()
    {
        return $this->belongsToMany(Announcement::class, 'announcement_reads')
            ->withPivot('read_at')
            ->withTimestamps();
    }

    /**
     * Get unread announcements count for this user
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
