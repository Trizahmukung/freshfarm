<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'location' => $this->location,
            'owner_id' => $this->owner_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products'=> $this->products,
            'latitude'=> $this->latitude,
            'longitude'=> $this->longitude,
            'description'=> $this->description,
            'verification_status'=> $this->verification_status,
            'address'=> $this->address,

            'owner' => new UserResource($this->whenLoaded('owner')),
            // 'products' =>  ProductResource::collection($this->whenLoaded('products')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'orders' => OrderResource::collection($this->whenLoaded('orders')),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
            'users' => UserResource::collection($this->whenLoaded('users')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
           // 'tags' => TagResource::collection($this->whenLoaded('tags')),
            'reviews_count' => $this->whenLoaded('reviews_count', function () {
                return $this->reviews_count;
            }),
            'average_rating' => $this->whenLoaded('average_rating', function () {
                return $this->average_rating;
            }),
        ];  
    }
}
