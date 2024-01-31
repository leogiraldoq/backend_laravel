<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateInstructionsCostumerRequest extends FormRequest
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
            "customerId" => "required|integer",
            "boutiques" => "required|array|min:1",
            "title" => "required|string|min:3|max:255",
            "customerInstructions" => "required|string",
            "sizeTicket" => "required|array",
            "sizeTicket.provide" => "nullable|string",
            "sizeTicket.place" => "nullable|string",
            "sizeTicket.careLabel" => "nullable|string",
            "hangTag" => "nullable|string",
            "bagging" => "required|array",
            "bagging.provide" => "nullable|string",
            "bagging.options" => "nullable|string",
            "hangers" => "nullable|string",
            "stickerSize" => "nullable|string",
            "packing" => "nullable|string",
            "shipping" => "nullable|string",
            "sampleImage" => "required|string",
            "specialObservations" => "nullable|string"
        ];
    }
}
