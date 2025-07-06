<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalInventoryStockOut extends Model
{
    protected $table = 'tbl_hospital_inventory_stock_out';

    protected $fillable = [
        'hospital_id',
        'blood_type',
        'qty',
    ];
}

