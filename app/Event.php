<?php

namespace App;

class Event extends Base
{
    protected $fillable = [
        'demo',
        'family_id',
        'title',
        'location',
        'comments',
        'google_id',
        'outlook_id',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}
