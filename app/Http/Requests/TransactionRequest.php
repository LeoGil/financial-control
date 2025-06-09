<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string|max:255',
            'date'               => 'required|date|before_or_equal:today',
            'amount'              => 'required|numeric|min:0.01',
            'credit_card_id'     => 'required|exists:credit_cards,id',
            'installment'        => 'required|integer|min:1|max:48',
            'category_id'        => 'required|exists:categories,id',
            'budget_category_id' => 'exists:budget_categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome deve ter no máximo 255 caracteres.',
            'description.string' => 'A descrição deve ser um texto.',
            'description.max' => 'A descrição deve ter no máximo 255 caracteres.',
            'date.required' => 'A data é obrigatória.',
            'date.date' => 'A data deve ser uma data válida.',
            'date.before_or_equal' => 'A data deve ser anterior ou igual ao dia atual.',
            'amount.required' => 'O valor é obrigatório.',
            'amount.numeric' => 'O valor deve ser um número.',
            'amount.min' => 'O valor deve ser maior ou igual a :min.',
            'credit_card_id.required' => 'O cartão de crédito é obrigatória.',
            'credit_card_id.exists' => 'O cartão de crédito selecionada nao existe.',
            'installment.required' => 'A quantidade de parcelas é obrigatória.',
            'installment.integer' => 'A quantidade de parcelas deve ser um número inteiro.',
            'installment.min' => 'A quantidade de parcelas deve ser maior ou igual a :min.',
            'installment.max' => 'A quantidade de parcelas deve ser menor ou igual a :max.',
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada não existe.',
            'budget_category_id.exists' => 'A categoria de orçamento selecionada não existe.'
        ];
    }
}
