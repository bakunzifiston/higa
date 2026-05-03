<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreMaizeCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'farmer_id' => ['required', 'integer', 'exists:farmers,id'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'product_name' => ['nullable', 'string', 'max:255'],
            'collection_date' => ['required', 'date'],
            'quantity_collected' => ['required', 'numeric', 'gt:0'],
            'quantity_rejected' => ['nullable', 'numeric', 'gte:0'],
            'rejection_reason' => ['nullable', 'string'],
            'price_per_kg' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
