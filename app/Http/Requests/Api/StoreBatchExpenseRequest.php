<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchExpenseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'production_batch_id' => ['required', 'integer', 'exists:production_batches,id'],
            'type' => ['required', 'in:labor,transport,packaging,utilities'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
