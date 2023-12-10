<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'f_name' => ['required', 'string', 'min:1', 'max:255'],
            'l_name' => ['required', 'string', 'min:1', 'max:255'],
            'company' => ['required', 'string', 'min:1', 'max:255'],
            'phone' => ['required', 'string', 'min:1', 'max:255'],
            'email' => ['required', 'string', 'min:1', 'max:255'],
            'line1' => ['required', 'string', 'min:1', 'max:255'],
            'line2' => ['nullable', 'string', 'min:1', 'max:255'],
            'city' => ['required', 'string', 'min:1', 'max:255'],
            'state' => ['required', 'string', 'min:1', 'max:255'],
            'country' => ['required', 'string', 'min:1', 'max:255'],
            'zip_code' => ['required', 'string', 'min:1', 'max:255'],
            'delivery_location' => ['required', 'string', 'in:dhaka,outside_dhaka,outside_bd'],
            'products.*.id' => ['required', 'exists:App\Models\Product,id'],
            'products.*.stock_id' => ['required', 'exists:App\Models\Stock,id'],
            'products.*.quantity' => ['required', 'numeric', 'min:1'],
        ];
    }
}
