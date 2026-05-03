<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaizeCollectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'farmer_id' => $this->farmer_id,
            'location_id' => $this->location_id,
            'product_name' => $this->product_name,
            'collection_date' => $this->collection_date,
            'quantity_collected' => $this->quantity_collected,
            'quantity_rejected' => $this->quantity_rejected,
            'accepted_quantity' => $this->accepted_quantity,
            'price_per_kg' => $this->price_per_kg,
            'rejection_reason' => $this->rejection_reason,
            'farmer' => new FarmerResource($this->whenLoaded('farmer')),
            'location' => new LocationResource($this->whenLoaded('location')),
        ];
    }
}
