<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'is_active' => $this->is_active,
            'packages' => ProductPackageResource::collection($this->whenLoaded('packages')),
            'created_at' => $this->created_at,
        ];
    }
}
