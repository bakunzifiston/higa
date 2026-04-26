<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPackageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'weight_kg' => $this->weight_kg,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }
}
