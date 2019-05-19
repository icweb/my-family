<?php

namespace App;

class FamilyUser extends Base
{
    protected $table = 'family_user';

    protected $fillable = [
        'demo',
        'family_id',
        'user_id',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
