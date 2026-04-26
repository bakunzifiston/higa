<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFarmerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $farmerId = $this->route('farmer')?->id ?? $this->route('farmer');

        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:40', Rule::unique('farmers', 'phone')->ignore($farmerId)],
            'country' => ['sometimes', 'required', 'string', 'max:120'],
            'province' => ['sometimes', 'required', 'string', 'max:120'],
            'district' => ['sometimes', 'required', 'string', 'max:120'],
            'sector' => ['sometimes', 'required', 'string', 'max:120'],
            'cell' => ['sometimes', 'required', 'string', 'max:120'],
            'village' => ['sometimes', 'required', 'string', 'max:120'],
        ];
    }
}
