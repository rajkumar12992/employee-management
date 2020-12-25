<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Candidate extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'description',
        'email',
        'phone_number',
    ];
    
}
