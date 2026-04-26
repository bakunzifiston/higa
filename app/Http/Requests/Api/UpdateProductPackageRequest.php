<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductPackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $packageId = $this->route('productPackage')?->id ?? $this->route('productPackage');
        $productId = $this->input('product_id', $this->route('productPackage')?->product_id);

        return [
            'product_id' => ['sometimes', 'required', 'integer', 'exists:products,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'weight_kg' => ['sometimes', 'required', 'numeric', 'gt:0', Rule::unique('product_packages', 'weight_kg')->where('product_id', $productId)->ignore($packageId)],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
