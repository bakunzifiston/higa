<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'amount' => $this->amount,
            'payment_method' => $this->payment_method,
            'reference' => $this->reference,
            'payment_date' => $this->payment_date,
        ];
    }
}
