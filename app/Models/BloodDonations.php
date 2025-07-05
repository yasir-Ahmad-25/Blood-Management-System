<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodDonations extends Model
{
    protected $table = 'blood_donations';
    protected $fillable = [
        'donor_id',
        'blood_type',
        'volume_ml',
        'donation_date',
        'location',
        'remarks',
    ];
}
