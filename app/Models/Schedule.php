<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'subject',
        'teacher',
        'room',
        'start_time',
        'end_time',
        'class'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    // Scope to get schedules for a specific day
    public function scopeForDay($query, $day)
    {
        return $query->where('day', $day)->orderBy('start_time');
    }

    // Scope to get schedules for a specific class
    public function scopeForClass($query, $class)
    {
        return $query->where('class', $class);
    }

    // Get formatted time range
    public function getTimeRangeAttribute()
    {
        return $this->start_time->format('H:i') . ' - ' . $this->end_time->format('H:i');
    }
}
