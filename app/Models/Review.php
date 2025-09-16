<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'farm_id',
        'user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the order that owns the review.
     */
    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    /**
     * Get the product that was reviewed.
     */
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    /**
     * Get the farm that was reviewed.
     */
    public function farm()
    {
        return $this->hasOne('App\Models\Farm', 'id', 'farm_id');
    }

    /**
     * Get the user who wrote the review.
     */
    public function user()
    {
        return $this->hasOne('App\Models\User','id','user_id');
    }


}