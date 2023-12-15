<?php

namespace App\Http\Requests\Stock;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStockRequest extends FormRequest
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
            'size_id' => ['nullable', 'exists:App\Models\Size,id'],
            'color_id' => ['nullable', 'exists:App\Models\Color,id'],
            'quantity' => ['required', 'numeric', 'min:1'],
            'price' => ['required', 'numeric'],
            'sales_price' => ['nullable', 'numeric'],
        ];
    }
}
