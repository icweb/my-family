<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'demo',
        'name',
        'maiden_name',
        'email',
        'password',
        'nickname',
        'phone_home',
        'phone_mobile',
        'address_street',
        'address_city',
        'address_state',
        'address_zip',
        'gender_id',
        'parent_1_id',
        'parent_2_id',
        'partner_id',
        'parent_1_relationship_id',
        'parent_2_relationship_id',
        'partner_relationship_id',
        'late',
        'historic',
        'birthday',
        'wedding_anniversary',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'datetime',
        'wedding_anniversary' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = [
        'marriages',
        'parents',
        'children'
    ];

    public function getMarriagesAttribute()
    {
        return $this->marriagesOne->merge($this->marriagesTwo);
    }

    public function getParentsAttribute()
    {
        $parents = [];

        if(isset($this->parentOneRelationship))
        {
            $parents[$this->parentOneRelationship->title] = $this->parentOne;
        }

        if(isset($this->parentTwoRelationship))
        {
            $parents[$this->parentTwoRelationship->title] = $this->parentTwo;
        }

        return (object) $parents;
    }

    public function getPartnersAttribute()
    {
        return (object) [
            $this->partnerRelationship->title => $this->partner
        ];
    }

    public function getChildrenAttribute()
    {
        return $this->childrenOne->merge($this->childrenTwo);
    }

    public function parentOne()
    {
        return $this->belongsTo(User::class, 'parent_1_id');
    }

    public function parentOneRelationship()
    {
        return $this->belongsTo(Relationship::class, 'parent_1_relationship_id');
    }

    public function parentTwo()
    {
        return $this->belongsTo(User::class, 'parent_2_id');
    }

    public function parentTwoRelationship()
    {
        return $this->belongsTo(Relationship::class, 'parent_2_relationship_id');
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function partnerRelationship()
    {
        return $this->belongsTo(Relationship::class, 'partner_relationship_id');
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function families()
    {
        return $this->hasManyThrough(Family::class, FamilyUser::class);
    }

    public function marriagesOne()
    {
        return $this->hasMany(Marriage::class, 'partner_1_id');
    }

    public function marriagesTwo()
    {
        return $this->hasMany(Marriage::class, 'partner_2_id');
    }

    public function childrenOne()
    {
        return $this->hasMany(User::class, 'parent_1_id');
    }

    public function childrenTwo()
    {
        return $this->hasMany(User::class, 'parent_2_id');
    }
}
