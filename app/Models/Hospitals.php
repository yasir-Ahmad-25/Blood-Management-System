<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
class Hospitals extends Authenticatable

{
    protected $table = 'hospitals';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'website',
        'contact_person',
        'region',
        'username',
        'password',
        'status',
    ];
}
