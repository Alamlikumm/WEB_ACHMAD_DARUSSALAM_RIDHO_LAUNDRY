<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransOrder extends Model
{
    use SoftDeletes;

    protected $table = 'trans_order';

    protected $fillable = [
        'id_customer',
        'order_code',
        'order_date',
        'order_end_date',
        'order_status',
        'order_pay',
        'order_change',
        'total',
    ];

    // Relasi: Order milik 1 Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    // Relasi: 1 Order punya banyak Detail
    public function details()
    {
        return $this->hasMany(TransOrderDetail::class, 'id_order');
    }

    // Relasi: 1 Order punya 1 Pickup
    public function pickup()
    {
        return $this->hasOne(TransLaundryPickup::class, 'id_order');
    }
}
