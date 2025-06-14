<x-layout>
    <x-form title="Nova transação" maxWidth="600px">
        @include('transactions._form', [
            'formAction' => route('transactions.store'),
            'isEdit' => false,
            'transaction' => $transaction,
            'creditCards' => $creditCards,
            'categories' => $categories,
            'budgetCategories' => $budgetCategories,
        ])
    </x-form>
</x-layout>