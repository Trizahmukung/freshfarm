<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'products' => ProductResource::collection($this->whenLoaded('products')),
            'farms' => FarmResource::collection($this->whenLoaded('farms')),
            'products_count' => $this->whenLoaded('products_count', function () {
                return $this->products_count;
            }),
            'farms_count' => $this->whenLoaded('farms_count', function () {
                return $this->farms_count;
            }), 
        ];
    }
}
