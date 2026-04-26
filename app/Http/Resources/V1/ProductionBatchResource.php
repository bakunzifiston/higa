<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductionBatchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'batch_number' => $this->batch_number,
            'location_id' => $this->location_id,
            'maize_used' => $this->maize_used,
            'quantity_produced' => $this->quantity_produced,
            'wastage_quantity' => $this->wastage_quantity,
            'quality_percentage' => $this->quality_percentage,
            'production_date' => $this->production_date,
            'notes' => $this->notes,
            'outputs' => $this->whenLoaded('outputs'),
            'wastage' => $this->whenLoaded('wastage'),
            'expenses' => $this->whenLoaded('expenses'),
        ];
    }
}
