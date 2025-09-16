<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
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
            'order_id' => $this->order_id,
            'status' => $this->status,
            'delivered_at' => $this->delivered_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => new OrderResource($this->whenLoaded('order')),
            'courier' => new UserResource($this->whenLoaded('courier')),
            'farm' => new FarmResource($this->whenLoaded('farm')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'reviews_count' => $this->whenLoaded('reviews_count', function () {
                return $this->reviews_count;
            }),
            'average_rating' => $this->whenLoaded('average_rating', function () {
                return $this->average_rating;
            }),
        ];
    }
}
