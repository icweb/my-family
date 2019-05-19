<?php

namespace App;

class Marriage extends Base
{
    protected $fillable = [
        'demo',
        'family_id',
        'partner_1_id',
        'partner_2_id',
        'partner_1_relationship_id',
        'partner_2_relationship_id',
        'marriage_date',
        'divorce_date',
    ];

    protected $casts = [
        'marriage_date' => 'datetime',
        'divorce_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function partnerOne()
    {
        return $this->belongsTo(User::class, 'partner_1_id');
    }

    public function partnerOneRelationship()
    {
        return $this->belongsTo(Relationship::class, 'partner_1_relationship_id');
    }

    public function partnerTwo()
    {
        return $this->belongsTo(User::class, 'partner_2_id');
    }

    public function partnerTwoRelationship()
    {
        return $this->belongsTo(Relationship::class, 'partner_2_relationship_id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
