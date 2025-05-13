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
            'closing_day' => 'required|integer|min:1|max:31',
            'due_day' => [
                'required',
                'integer',
                'min:1',
                'max:31',
                function ($attribute, $value, $fail) {
                    if ($value <= $this->input('closing_day')) {
                        $fail('O dia de vencimento deve ser maior que o dia de fechamento.');
                    }
                },
            ],
            'credit_limit' => [
                'required',
                'regex:/^\d{1,10}(\.\d{1,2})?$/',
                function ($attribute, $value, $fail) {
                    if ((float)$value <= 0) {
                        $fail('O limite de crédito deve ser um número positivo.');
                    }
                },
            ],
            'account_id' => 'required|exists:accounts,id'
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Em caso de update, você pode ajustar algumas regras
            // Ex: permitir que alguns campos sejam opcionais
        }

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
            'credit_limit.required' => 'O limite de crédito é obrigatório.',
            'credit_limit.regex' => 'Formato inválido: até 12 dígitos, com 2 casas decimais.',
            'account_id.required' => 'O da conta é obrigatório.',
            'account_id.exists' => 'A conta selecionada não existe.'
        ];
    }
}
