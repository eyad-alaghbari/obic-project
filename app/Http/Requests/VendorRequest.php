<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
        // dd($this->request);
        $vendorId = $this->route('id') ?? null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email,' . $vendorId,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // تحديد الامتداد وحجم الصورة
            'status' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => config('validation-messages.vendor.name_required'),
            'email.required' => config('validation-messages.vendor.email_required'),
            'email.unique' => config('validation-messages.vendor.email_unique'),
            'status.boolean' => config('validation-messages.vendor.status_boolean'),
            'logo.mimes' => config('validation-messages.vendor.logo_mimes'),
            'logo.max' => config('validation-messages.vendor.logo_max'),
            'logo.image' => config('validation-messages.vendor.logo_image'),
        ];
    }

}
