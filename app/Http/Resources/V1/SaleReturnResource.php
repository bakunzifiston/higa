<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleReturnResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sale_id' => $this->sale_id,
            'sale_item_id' => $this->sale_item_id,
            'quantity' => $this->quantity,
            'reason' => $this->reason,
            'refund_status' => $this->refund_status,
            'refund_amount' => $this->refund_amount,
            'return_date' => $this->return_date,
        ];
    }
}
