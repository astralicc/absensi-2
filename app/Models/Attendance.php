<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'check_in',
        'check_out',
        'status'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'check_in' => 'datetime:Y-m-d H:i:s',
        'check_out' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the siswa that owns the attendance.
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'user_id');
    }

    /**
     * Alias for backward compatibility with views
     */
    public function user()
    {
        return $this->belongsTo(Siswa::class, 'user_id');
    }
}
