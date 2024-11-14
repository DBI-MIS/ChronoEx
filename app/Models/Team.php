<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        
        'is_active' => 'boolean',

    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_teams')->withPivot(['order'])->withTimestamps();
    }
}
