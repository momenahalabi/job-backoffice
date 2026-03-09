<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyCreateRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'type' => 'required|string|in:Full-Time,Part-Time,Remote,Hybrid,Contract',
            'companyId' => 'required|exists:companies,id',
            'jobCategoryId' => 'required|exists:job_categories,id',
            'description' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The job title is required.',
            'location.required' => 'The job location is required.',
            'salary.required' => 'The job salary is required.',
            'salary.numeric' => 'The salary must be a valid number.',
            'description.required' => 'The job description is required.',
            'companyId.required' => 'Please select a company.',
            'jobCategoryId.required' => 'Please select a job category.',
        ];
    }
}
