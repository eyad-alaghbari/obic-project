<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomizationOptionRequest extends FormRequest
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
            'value' => 'required|string|max:255',
            'customization_id' => 'required|integer|exists:customizations,id',
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'value.required' => config('validation-messages.customization_option.value_required'),
            'value.max' => config('validation-messages.customization_option.value_max'),
            'value.string' => config('validation-messages.customization_option.value_string'),
            'customization_id.required' => config('validation-messages.customization_option.customization_id_required'),
            'customization_id.integer' => config('validation-messages.customization_option.customization_id_integer'),
            'customization_id.exists' => config('validation-messages.customization_option.customization_id_exists'),
        ];
    }

}
