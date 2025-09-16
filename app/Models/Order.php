<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'farm_id',
        'status',
        'notes',
        'subtotal',
        'tax_amount',
        'delivery_fee',
        'total_amount',
        'fulfillment_method',
        'delivery_address',
        'delivery_lat',
        'delivery_lng',
        'scheduled_pickup_time',
        'scheduled_delivery_time',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'delivery_lat' => 'decimal:8',
        'delivery_lng' => 'decimal:8',
        'scheduled_pickup_time' => 'datetime',
        'scheduled_delivery_time' => 'datetime',
    ];

    /**
     * Get the user (consumer) that placed the order.
     */
    public function consumer()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    /**
     * Get the farm that fulfills the order.
     */
    public function farm()
    {
        return $this->hasOne('App\Models\Farm', 'id', 'farm_id');
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItem', 'order_id', 'id');
    }

    /**
     * Get the delivery record for the order.
     */
    public function delivery()
    {
        return $this->hasOne('App\Models\Delivery', 'id', 'order_id');
    }

    /**
     * Get the reviews for the order.
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'order_id', 'id');
    }

    /**
     * Check if order can be reviewed.
     */
    public function canBeReviewed()
    {
        return $this->status === 'delivered';
    }
}