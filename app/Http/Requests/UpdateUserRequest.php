<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'userd' => 'required|integer',
            'username' => 'required|min:6|max:50',
            'current_password' => 'required|string|min:60|max:60',
            'new_password' => 'required|string|min:60|max:60',
            'new_password_confirmation' => 'required|string|min:60|max:60'
        ];
    }
}
