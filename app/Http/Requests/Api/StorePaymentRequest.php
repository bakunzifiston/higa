<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sale_id' => ['required', 'integer', 'exists:sales,id'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment_method' => ['required', 'in:cash,mobile_money,bank_transfer,credit'],
            'reference' => ['nullable', 'string', 'max:100'],
            'payment_date' => ['required', 'date'],
        ];
    }
}
