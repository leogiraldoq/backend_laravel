<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBoutiqueRequest extends FormRequest
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
            'costumerId' => 'required|integer',
            'name' => 'required|string|min:4|max:50',
            'address' => 'required|string|min:4|max:50',
            'city' => 'required|string|min:4|max:50',
            'contact' => 'required|array|min:1',
            'contact.*' => 'required|array',
            'contact.*.contact_name' => 'required|string|min:4|max:50',
            'contact.*.email' => 'required|email|min:10|max:255',
            'contact.*.phone' => 'required|string|min:10|max:20',
        ];
    }
}
