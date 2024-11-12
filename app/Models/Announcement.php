<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{

    Use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'is_active',
        'channel',
        'start_date',
        'end_date',    ];

    protected $casts = [
        
        'is_active' => 'boolean',

    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function getExcerpt()
{
    return \Illuminate\Support\Str::limit(strip_tags($this->content), 30, '...');
}

  
}
