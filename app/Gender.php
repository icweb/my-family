<?php

namespace App;

class Gender extends Base
{
    protected $table = 'lookup_genders';

    protected $fillable = [
        'title'
    ];
}
