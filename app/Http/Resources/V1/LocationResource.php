<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'country' => $this->country,
            'province' => $this->province,
            'district' => $this->district,
            'sector' => $this->sector,
            'cell' => $this->cell,
            'village' => $this->village,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }
}
