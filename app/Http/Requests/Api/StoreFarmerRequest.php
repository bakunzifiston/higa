<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreFarmerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:40', 'unique:farmers,phone'],
            'country' => ['required', 'string', 'max:120'],
            'province' => ['required', 'string', 'max:120'],
            'district' => ['required', 'string', 'max:120'],
            'sector' => ['required', 'string', 'max:120'],
            'cell' => ['required', 'string', 'max:120'],
            'village' => ['required', 'string', 'max:120'],
        ];
    }
}
