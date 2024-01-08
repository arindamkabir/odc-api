<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'min_cart_value' => ['required', 'numeric'],
            'value' => ['required', 'numeric'],
            'value_type' => ['required', 'string', 'in:fixed,percentage'],
            'max_value' => ['nullable', 'numeric'],
            'is_disabled' => ['required', 'boolean'],
            'redemptions' => ['required', 'integer', 'min:-2147483648', 'max:2147483647'],
            'expiry_date' => ['required']
        ];
    }
}
