<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductPackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'weight_kg' => ['required', 'numeric', 'gt:0', Rule::unique('product_packages', 'weight_kg')->where('product_id', $this->integer('product_id'))],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
