<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateSchedule extends Model
{
    protected $fillable = [
        'user_id',
        'day_of_week',
        'week',
        'start_time',
        'end_time',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

}
