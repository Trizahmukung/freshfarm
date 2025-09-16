<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
        'latitude',
        'longitude',
        'verification_status',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the user (farmer) that owns the farm.
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

     /**
     * Get the products for the farm.
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'farm_id', 'id');
    }

    /**
     * Get the orders for the farm.
     */
    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'farm_id', 'id');
    }

    /**
     * Get the reviews for the farm.
     */
    public function reviews()
    {
        return $this->hasMany('App\Models\Review', 'farm_id', 'id');
    }


}

