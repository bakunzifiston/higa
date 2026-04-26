<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locationId = $this->route('location')?->id ?? $this->route('location');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'code' => ['sometimes', 'required', 'string', 'max:80', Rule::unique('locations', 'code')->ignore($locationId)],
            'country' => ['sometimes', 'required', 'string', 'max:120'],
            'province' => ['sometimes', 'required', 'string', 'max:120'],
            'district' => ['sometimes', 'required', 'string', 'max:120'],
            'sector' => ['sometimes', 'required', 'string', 'max:120'],
            'cell' => ['sometimes', 'required', 'string', 'max:120'],
            'village' => ['sometimes', 'required', 'string', 'max:120'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
