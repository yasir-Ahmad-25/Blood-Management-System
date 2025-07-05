<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donors extends Model
{
    protected $fillable = [
        'fullname',
        'email',
        'phone',
        'blood_type',
        'sex',
        'date_of_birth',
        'address',
    ];
}
