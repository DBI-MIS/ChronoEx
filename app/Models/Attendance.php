<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    Use SoftDeletes;

    protected $fillable = [
        'user_id',
        'time_in',
        'time_out',
        'is_timed_in',
        'is_timed_out',
        'early_login',
        'late_login',
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

    public function getTimeInAttribute($value)
{
    return $value ? Carbon::parse($value)->format('h:i A') : null;
}
    
    public function getTimeOutAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('h:i A') : null;
    }

//     public function scopeToday($query)
// {
//     return $query->whereDate('time_in', Carbon::today());
// }


}
