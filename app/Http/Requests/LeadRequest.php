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
                'client_name' => 'required|string',
                'tech_stack' => 'required|string',
                'connects_spent' => 'required|string',
                'rate_type' => 'required|string',
                'rate_value' => 'required|numeric',
                'proposal_name' => 'required|string',
                'proposal_link' => 'required|string',
                'country' => 'required|string',
                'proposal_date' => 'required|date',
            ];
    }
}
