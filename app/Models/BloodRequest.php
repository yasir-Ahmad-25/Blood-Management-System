<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodRequest extends Model
{
    protected $table = 'tbl_blood_requests';

    protected $primaryKey = 'request_id';

    protected $fillable = [
        'hospital_id',
        'blood_type',
        'qty',
        'status',
        'requested_date',
    ];
}

