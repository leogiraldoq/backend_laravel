<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRecibingRequest extends FormRequest
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
            'user' => 'nullable',
            'shipper' => 'required',
            'customer' => 'required',
            'observations' => 'nullable|string|min:5|max:255',
            'photo' => 'required',
            'process' => 'required|string',
            'receive' => 'required|array|min:1',
            'receive.*.boutique' => 'required',
            'receive.*.box' => 'required',
            'receive.*.quantity' => 'required|numeric|min:1|max:150',
            'receive.*.weight' => 'required|numeric'
        ];
    }
}
