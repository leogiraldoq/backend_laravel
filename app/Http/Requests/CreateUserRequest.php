<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username' => 'required|min:6|max:50|unique:users',
            'employeeId' => 'integer|required'
        ];
    }

    /**
     * Custom message for validation
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username is required!',
            'username.min' => 'Username cant have less than 6 characters!',
            'username.max' => 'Username have more than 255 characters!',
            'username.unique' => 'The username alredy exists, remember the username will be unique!'
        ];
    }
}
