<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules()
    {
        $rules = [
            'name' => 'required|string'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.'
        ];
    }
}
