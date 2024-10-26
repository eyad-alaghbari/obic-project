<?php

namespace App\Http\Requests;

use App\Rules\ParentIdNotNull;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        // dd($this);
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'vendor_id' => 'required|exists:vendors,id',
            'category_ids' => 'required|array',
            'category_ids.*' => [new ParentIdNotNull],
            'customization_option_ids' => 'nullable|array',
            'customization_option_ids.*' => 'exists:customization_options,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'price.required' => 'Price is required.',
            'vendor_id.exists' => 'Selected vendor does not exist.',
            'category_ids.required' => 'At least one category is required.',
            // 'category_ids.*.exists' => 'Selected category does not exist.',
            'customization_option_ids.*.exists' => 'One or more customization options do not exist.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            'images.*.max' => 'Each image must not exceed 2MB.',
        ];
    }
}
