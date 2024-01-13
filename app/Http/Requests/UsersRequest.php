<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => 'required|max:255',
            'email'=>'required|email|unique:users',
            'city' => 'required',
            'zipcode' => 'required|max:255',
            'phone' => 'required|max:35',
            'website' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field must not exceed 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'The email address is already in use.',
            'city.required' => 'The city field is required.',
            'zipcode.required' => 'The zipcode field is required.',
            'zipcode.max' => 'The zipcode field must not exceed 255 characters.',
            'phone.required' => 'The phone field is required.',
            'phone.max' => 'The phone field must not exceed 35 characters.',
            'website.max' => 'The website field must not exceed 255 characters.',
        ];
    }
}
