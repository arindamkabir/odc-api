<?php

namespace App\Http\Requests\Color;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateColorRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', Rule::unique('colors', 'name')->ignore($this->route()->id ?? 0)],
            'hex_code' => ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', Rule::unique('colors', 'hex_code')->ignore($this->route()->id ?? 0)],
        ];
    }
}
