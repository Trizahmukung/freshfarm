<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'user_id' => $this->user_id,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'farm' => new FarmResource($this->whenLoaded('farm')),
            'consumer' => new UserResource($this->whenLoaded('consumer')),  
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'delivery' => new DeliveryResource($this->whenLoaded('delivery')),
            'reviews_count' => $this->whenLoaded('reviews_count', function () {
                return $this->reviews_count;
            }),
            'average_rating' => $this->whenLoaded('average_rating', function () {
                return $this->average_rating;
            }),
        ];
    }
}
