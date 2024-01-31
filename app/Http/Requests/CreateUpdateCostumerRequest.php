<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateCostumerRequest extends FormRequest
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
            'pickUpCompanyId' => 'required|integer',
            'name' => 'required|min:3|max:255|unique:costumers',
            'upsNumberAccount' => 'nullable|string',
            'boutiques' => 'required|array|min:1',
            'boutiques.*.name' => 'required|string|min:5|max:100',
            'boutiques.*.address' => 'required|string|min:10|max:255',
            'boutiques.*.city' => 'required|string|min:3|max:50',
            'boutiques.*.final_destination' => 'required|string|min:3|max:255',
            'boutiques.*.contacts' => 'required|array|min:1',
            'boutiques.*.contacts.*.contact_name' => 'required|string|min:5|max:50',
            'boutiques.*.contacts.*.phone' => 'required|string|min:10|max:14',
            'boutiques.*.contacts.*.email' => 'required|email|min:5|max:150',
        ];
    }
}
