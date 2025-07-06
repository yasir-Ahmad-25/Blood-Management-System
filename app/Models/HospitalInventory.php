<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalInventory extends Model
{
    protected $table = 'tbl_hospital_inventory';

    protected $primaryKey = "inventory_id";
    protected $fillable = [
        'hospital_id',
        'blood_type',
        'qty',
        'status',
    ];
}

