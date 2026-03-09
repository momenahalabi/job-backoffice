<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
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
            // Company Details
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
            'description' => 'required|string|max:1000',

            // Owner Details
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|string|email|max:255|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ];

    }

    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'name.unique' => 'The company name has already been taken.',
            'address.required' => 'The company address is required.',
            'industry.required' => 'The company industry is required.',
            'description.required' => 'The company description is required.',
            'website.url' => 'The company website must be a valid URL.',
            'owner_name.required' => 'The owner name is required.',
            'owner_email.required' => 'The owner email is required.',
            'owner_email.unique' => 'This email is already registered.',
            'owner_password.required' => 'The owner password is required.',
            'owner_password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
