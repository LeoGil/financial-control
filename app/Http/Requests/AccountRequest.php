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
            'name' => 'required|string',
            'closing_day' => 'required|integer|min:1|max:31',
            'due_day' => [
                'required',
                'integer',
                'min:1',
                'max:31',
            ],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'closing_day.required' => 'O dia de fechamento é obrigatório.',
            'closing_day.integer' => 'O dia de fechamento deve ser um número inteiro.',
            'closing_day.min' => 'O dia de fechamento deve ser maior ou igual a :min.',
            'closing_day.max' => 'O dia de fechamento deve ser menor ou igual a :max.',
            'due_day.required' => 'O dia de vencimento é obrigatório.',
            'due_day.integer' => 'O dia de vencimento deve ser um número inteiro.',
            'due_day.min' => 'O dia de vencimento deve ser maior ou igual a :min.',
            'due_day.max' => 'O dia de vencimento deve ser menor ou igual a :max.',
        ];
    }
}
