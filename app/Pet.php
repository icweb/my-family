<?php

namespace App;

class Pet extends Base
{
    protected $fillable = [
        'demo',
        'name',
        'family_id',
        'type_id',
        'gender_id',
        'user_id',
    ];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function petType()
    {
        return $this->belongsTo(PetType::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
