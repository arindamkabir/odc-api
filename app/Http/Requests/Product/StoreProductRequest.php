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
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:App\Models\Category,id'],
            'description' => ['required'],
            'price' => ['required', 'numeric'],
            'SKU' => ['required'],
            'primary_img' => ['required', 'image'],
            'secondary_img' => ['image'],
            'is_featured' => ['required', 'string'],
            'is_hidden' => ['required', 'string'],
        ];
    }
}
