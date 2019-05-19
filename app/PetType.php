<?php

namespace App;

class PetType extends Base
{
    protected $table = 'lookup_pet_types';

    protected $fillable = [
        'title'
    ];
}
