<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodInventory extends Model
{
    protected $table = 'blood_inventories';

    protected $primaryKey = 'blood_id';

    protected $fillable = [
        'blood_type',
        'volume',
        'donor_id',
        'collection_date',
        'expiration_date',
        'status'
    ];

    public $timestamps = true;

    // Define any relationships if necessary
    // For example, if you have a Donor model:
    // public function donor()
    // {
    //     return $this->belongsTo(Donor::class, 'donor_id');
    // }
}
