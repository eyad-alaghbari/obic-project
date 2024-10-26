<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductParamsRequest extends FormRequest
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
            'search' => 'nullable|string',
            'vendor_id' => 'nullable|integer|exists:vendors,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'custom_options' => 'nullable|array',
            'custom_options.*' => 'nullable|integer|exists:customization_options,id',
            'price_sort' => 'nullable|in:asc,desc',
            'stock_sort' => 'nullable|in:asc,desc',
            'per_page' => 'nullable|integer|min:1|max:100',
            'relations' => 'nullable|array',
            'relations.*' => 'nullable|string|in:images,vendors,customizations',
        ];
    }

    public function messages()
    {
        return config('validation-messages.params');
    }
}
