<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
                'user_id' =>'required',
                'client_name' => 'required|regex:/^[a-zA-Z\s]+$/',
                'tech_stack' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'connects_spent' => 'required|integer',
                'rate_type' => 'required|string',
                'rate_value' => 'required|integer',
                'proposal_name' => 'required|string|regex:/^[a-zA-Z\s]+$/',
                'proposal_link' => 'required|string',
                'country' => 'required|string',
                'proposal_date' => 'required|date',
            ];
    }

     /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'client_name.required' => 'Client name is required.',
            'client_name.regex' => 'Client name should only contain alphabets.',
        ];
    }
}
