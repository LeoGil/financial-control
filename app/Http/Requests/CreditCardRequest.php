<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditCardRequest extends FormRequest
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
            'credit_limit' => [
                'nullable',
                'regex:/^\d{1,10}(\.\d{1,2})?$/',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && (float)$value <= 0) {
                        $fail('O limite de crédito deve ser um número positivo.');
                    }
                },
            ],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'credit_limit.regex' => 'Formato do limite inválido: até 12 dígitos, com 2 casas decimais.',
        ];
    }
}
