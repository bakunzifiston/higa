<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id ?? $this->route('product');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'name')->ignore($productId)],
            'sku' => ['sometimes', 'required', 'string', 'max:120', Rule::unique('products', 'sku')->ignore($productId)],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
