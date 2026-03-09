<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampanyUpdatRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:campanies,name,'.$this->route('campany'),
            'address' =>'required|string|max:255',
            'industry' =>'required|string|max:255',
            'website' => 'nullable|string|url|max:555',
                   ];
    }

    public function messages(): array
{
    return [
        'name.required' => 'The campany name is required.',
        'name.unique' => 'The campany name has already been taken.',
        'name.max' => 'The campany name must be less than 255 characters.',
        'name.string' => 'The campany name must be a string.',
        'address.required' => 'The campany address is required.',
        'address.max' => 'The campany address must be less than 255 characters.',
        'address.string' => 'The campany address must be a string.',
        'industry.required' => 'The campany industry is required.',
        'industry.max' => 'The campany industry must be less than 255 characters.',
        'industry.string' => 'The campany industry must be a string.',
        'website.url' => 'The campany website must be a valid URL.',
        'website.max' => 'The campany website must be less than 255 characters.',
        'website.string' => 'The campany website must be a string.',
        
    ];
}
}
