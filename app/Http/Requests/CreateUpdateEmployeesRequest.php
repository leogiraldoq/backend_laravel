<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateEmployeesRequest extends FormRequest
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
            'names' => 'required|min:4|max:50',
            'last_names' => 'required|min:4|max:50',
            'phone' => 'required|min:12|max:13|unique:employees',
            'email' => 'required|email|unique:employees',
            'title' => 'min:3|max:20',
            'address' => 'min:10|max:50',
            'city' => 'min:5|max:20',
            'postal_code' => 'min:5|max:5',
            'birth' => 'date',
        ];
    }

    /**
     * Custom message for validation
     * @return array
     */
    public function messages(): array
    {
        return [
            'names.required' => 'Name employee is required!',
            'names.min' => 'Name employee cant have less than 4 characters!',
            'names.max' => 'Name employee have more than 50 characters!',
            'last_names.required' => 'Lastname employee is required!',
            'last_names.min' => 'Lastname employee cant have less than 4 characters!',
            'last_names.max' => 'Lastname employee have more than 50 characters!',
            'phone.required' => 'Phone number employee is required!',
            'phone.min' => 'Phone number employee  cant have less than 13 characters!',
            'phone.max' => 'Phone number employee have more than 13 characters!',
            'email.required' => 'Email employee is required!',
            'email.email' => 'The email employe is not correcta form!',
        ];
    }
}
