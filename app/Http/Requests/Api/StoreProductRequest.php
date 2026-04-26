<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'sku' => ['required', 'string', 'max:120', 'unique:products,sku'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
