<?php

namespace App;

class Family extends Base
{
    protected $fillable = [
        'demo',
        'title',
        'maternal_name',
        'fraternal_name',
        'mother_id',
        'father_id',
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function familyUsers()
    {
        return $this->hasMany(FamilyUser::class, 'family_id', 'id');
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, FamilyUser::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function marriages()
    {
        return $this->hasMany(Marriage::class);
    }

    public function mother()
    {
        return $this->belongsTo(User::class);
    }

    public function father()
    {
        return $this->belongsTo(User::class);
    }
}
