<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FarmerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'country' => $this->country,
            'province' => $this->province,
            'district' => $this->district,
            'sector' => $this->sector,
            'cell' => $this->cell,
            'village' => $this->village,
            'collections_count' => $this->whenCounted('collections', $this->collections_count),
            'created_at' => $this->created_at,
        ];
    }
}
