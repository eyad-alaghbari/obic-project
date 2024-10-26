<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'price' => $this->price,
            'stock' => $this->stock,
            'vendor' => VendorResource::make($this->whenLoaded('vendor')),
            'category' => CategoryResource::collection($this->whenLoaded('category')),
            'customizationOptions' => CustomizationOptionResource::collection($this->whenLoaded('customizationOptions')),
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
