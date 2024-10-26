<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncCustomizationsRequest extends FormRequest
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
            'customizationIds' => 'required|array',
            'customizationIds.*' => 'required|exists:customizations,id',
        ];
    }

    public function messages(): array
    {
        return [
            'customizationIds.required' => config('validation-messages.customization.customizations_required'),
            'customizationIds.array' => config('validation-messages.customization.customizations_array'),
            'customizationIds.*.required' => config('validation-messages.customization.customizations_required'),
            'customizationIds.*.exists' => config('validation-messages.customization.id_exists'),
        ];
    }
}
