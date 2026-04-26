<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sale_id' => ['required', 'integer', 'exists:sales,id'],
            'sale_item_id' => ['required', 'integer', 'exists:sale_items,id'],
            'quantity' => ['required', 'numeric', 'gt:0'],
            'reason' => ['required', 'string', 'max:255'],
            'refund_status' => ['nullable', 'in:pending,partially_refunded,refunded'],
            'return_date' => ['required', 'date'],
        ];
    }
}
