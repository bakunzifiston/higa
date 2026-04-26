<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:80', 'unique:locations,code'],
            'country' => ['required', 'string', 'max:120'],
            'province' => ['required', 'string', 'max:120'],
            'district' => ['required', 'string', 'max:120'],
            'sector' => ['required', 'string', 'max:120'],
            'cell' => ['required', 'string', 'max:120'],
            'village' => ['required', 'string', 'max:120'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
