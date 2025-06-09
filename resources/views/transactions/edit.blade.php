<x-layout>
    <x-form title="Editar transação" maxWidth="600px">
        @include('transactions._form', [
            'formAction' => route('transactions.update', $transaction->id),
            'isEdit' => true,
            'transaction' => $transaction,
            'creditCards' => $creditCards,
            'categories' => $categories,
            'budgetCategories' => $budgetCategories,
        ])
    </x-form>
</x-layout>
