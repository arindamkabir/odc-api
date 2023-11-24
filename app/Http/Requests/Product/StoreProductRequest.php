<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required'],
            'categoryId' => ['required', 'exists:App\Models\Category,id'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'SKU' => ['required'],
            'primaryImg' => ['required', 'image'],
            'secondaryImg' => ['image'],
            'isFeatured' => ['required', 'boolean'],
            'isHidden' => ['required', 'boolean'],
        ];
    }
}
