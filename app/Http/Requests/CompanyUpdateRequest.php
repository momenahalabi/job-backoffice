<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
        $companyId = $this->route('company');
        $ownerId = $this->company_owner_id; // Added as a hidden field in the form

        return [
            // Company Details
            'name' => 'required|string|max:255|unique:companies,name,'.$companyId,
            'address' => 'required|string|max:255',
            'industry' => 'required|string|max:255',
            'website' => 'nullable|string|url|max:255',
            'description' => 'required|string|max:1000',

            // Owner Details
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|string|email|max:255|unique:users,email,'.$ownerId,
            'owner_password' => 'nullable|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The company name is required.',
            'name.unique' => 'The company name has already been taken.',
            'owner_email.unique' => 'This email is already registered to another user.',
            'owner_password.min' => 'The password must be at least 8 characters.',
        ];
    }
}
