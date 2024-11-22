<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'time_in',
        'time_out',
        'is_timed_in',
        'is_timed_out',
        'early_login',
        'late_login',
        'lunch_start',
        'lunch_end',
        'break_start',
        'break_end',
    ];

    protected $casts = [
        'early_login' => 'bolean',
        'late_login' => 'bolean',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function team()
    // {
    //     return $this->belongsToMany(User::class, 'team');
    // }

    // public function getTimeAttribute($value)
    // {
    //     return \Carbon\Carbon::parse($value)->format('h:i A');
    // }

    public function getLunchStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }

    public function getLunchEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }

    public function getBreakStartAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }

    public function getBreakEndAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }

    //     public function scopeToday($query)
    // {
    //     return $query->whereDate('time_in', Carbon::today());
    // }

    public function calculateWorkHours()
{
    $timeIn = $this->time_in ? Carbon::parse($this->time_in) : null;
    $timeOut = $this->time_out ? Carbon::parse($this->time_out) : null;
    $lunchDuration = $this->lunch_start && $this->lunch_end
        ? Carbon::parse($this->lunch_end)->diffInMinutes(Carbon::parse($this->lunch_start))
        : 0;
    $breakDuration = $this->break_start && $this->break_end
        ? Carbon::parse($this->break_end)->diffInMinutes(Carbon::parse($this->break_start))
        : 0;

    if ($timeIn && $timeOut) {
        $totalMinutes = $timeOut->diffInMinutes($timeIn) - ($lunchDuration + $breakDuration);
        return round($totalMinutes / 60, 2); // Return in hours
    }

    return null; // Not enough data
}

}
