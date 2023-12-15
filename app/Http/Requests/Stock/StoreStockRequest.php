<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
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
            'product_id' => ['required', 'exists:App\Models\Product,id'],
            'size_id' => ['nullable', 'exists:App\Models\Size,id'],
            'color_id' => ['nullable', 'exists:App\Models\Color,id'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'price' => ['required', 'numeric'],
            'sales_price' => ['nullable', 'numeric'],
        ];
    }
}
