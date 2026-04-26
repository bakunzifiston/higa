<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_number' => ['required', 'string', 'max:120', 'unique:sales,invoice_number'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:80'],
            'customer_address' => ['nullable', 'string'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'payment_method' => ['required', 'in:cash,mobile_money,bank_transfer,credit'],
            'delivery_status' => ['nullable', 'in:pending,in_transit,delivered'],
            'sale_date' => ['required', 'date'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.product_package_id' => ['required', 'integer', 'exists:product_packages,id'],
            'items.*.production_batch_id' => ['nullable', 'integer', 'exists:production_batches,id'],
            'items.*.quantity' => ['required', 'numeric', 'gt:0'],
            'items.*.price' => ['required', 'numeric', 'gt:0'],
        ];
    }
}
