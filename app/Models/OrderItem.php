<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    /**
     * Get the product that owns the order item.
     */
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    /**
     * Calculate the total price for this order item.
     */
    public function getTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}