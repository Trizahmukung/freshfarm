<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'unit',
        'stock_quantity',
        'harvest_date',
        'is_available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'harvest_date' => 'date',
        'is_available' => 'boolean',
    ];

    /**
     * Get the farm that owns the product.
     */
    public function farm()
    {
        return $this->hasOne('App\Models\Farm', 'id', 'farm_id');
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany('App\Models\OrderItem', 'product_id', 'id');
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany('App\Model\Review', 'product_id', 'id');
    }

    /**
     * Accessor for is_fresh attribute.
     * Product is considered fresh if harvested within the last 3 days.
     */
    /*public function getIsFreshAttribute()
    {
        if (!$this->harvest_date) {
            return false;
        }
        
        return $this->harvest_date->gt(Carbon::now()->subDays(3));
    } */
   
}