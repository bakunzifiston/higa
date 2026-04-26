<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductionBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_number' => ['required', 'string', 'max:100', 'unique:production_batches,batch_number'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'maize_used' => ['required', 'numeric', 'gt:0'],
            'quantity_produced' => ['required', 'numeric', 'gt:0'],
            'wastage_quantity' => ['required', 'numeric', 'gte:0'],
            'wastage_reason' => ['nullable', 'string'],
            'quality_percentage' => ['required', 'numeric', 'between:0,100'],
            'production_date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'outputs' => ['required', 'array', 'min:1'],
            'outputs.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'outputs.*.product_package_id' => ['required', 'integer', 'exists:product_packages,id'],
            'outputs.*.quantity' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
