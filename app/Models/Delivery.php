<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'driver_id',
        'status',
        'notes',
        'estimated_delivery_time',
        'actual_delivery_time',
    ];

    protected $casts = [
        'estimated_delivery_time' => 'datetime',
        'actual_delivery_time' => 'datetime',
    ];

    /**
     * Get the order for the delivery.
     */
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    /**
     * Get the driver assigned to the delivery.
     */
    /*public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }*/
    

    /**
     * Mark delivery as delivered.
     */
    public function markAsDelivered()
    {
        $this->update([
            'status' => 'delivered',
            'actual_delivery_time' => now(),
        ]);
    }
}