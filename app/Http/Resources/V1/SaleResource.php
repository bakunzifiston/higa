<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'customer_address' => $this->customer_address,
            'location_id' => $this->location_id,
            'payment_method' => $this->payment_method,
            'delivery_status' => $this->delivery_status,
            'total_amount' => $this->total_amount,
            'sale_date' => $this->sale_date,
            'items' => $this->whenLoaded('items'),
            'payments' => $this->whenLoaded('payments'),
            'returns' => $this->whenLoaded('returns'),
        ];
    }
}
