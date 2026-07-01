<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = 'customer';

    protected $fillable = [
        'customer_name',
        'phone',
        'address',
    ];

    // Relasi: 1 Customer punya banyak Order
    public function orders()
    {
        return $this->hasMany(TransOrder::class, 'id_customer');
    }

    // Relasi: 1 Customer punya banyak Pickup
    public function pickups()
    {
        return $this->hasMany(TransLaundryPickup::class, 'id_customer');
    }
}
