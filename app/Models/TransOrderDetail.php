<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransOrderDetail extends Model
{
    protected $table = 'trans_order_detail';

    protected $fillable = [
        'id_order',
        'id_service',
        'qty',
        'subtotal',
        'notes',
    ];

    // Relasi: Detail milik 1 Order
    public function order()
    {
        return $this->belongsTo(TransOrder::class, 'id_order');
    }

    // Relasi: Detail milik 1 Service
    public function service()
    {
        return $this->belongsTo(TypeOfService::class, 'id_service');
    }
}
