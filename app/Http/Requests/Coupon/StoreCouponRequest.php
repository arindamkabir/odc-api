<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'min:1', 'max:255'],
            'min_cart_value' => ['required', 'numeric'],
            'value' => ['required', 'numeric'],
            'value_type' => ['required', 'string', 'in:fixed,percentage'],
            'max_value' => ['nullable', 'numeric'],
            'is_disabled' => ['required', 'boolean'],
            'redemptions' => ['required', 'integer', 'min:0', 'max:2147483647'],
            'expiry_date' => ['required', 'date']
        ];
    }
}
