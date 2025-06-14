<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Repositories\BudgetCategoryRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CreditCardRepository;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(TransactionRepository $transactionRepository)
    {
        $search = request('search');
        $transactions = $transactionRepository->getByUserId(Auth::id(), 10, $search);

        return view('transactions.index', compact('transactions', 'search'));
    }

    public function create(
        CreditCardRepository $creditCardRepository,
        CategoryRepository $categoryRepository,
        BudgetCategoryRepository $budgetCategoryRepository
    ) {
        $transaction = new Transaction();
        $creditCards = $creditCardRepository->getByUserId(Auth::user()->id);
        $categories = $categoryRepository->getByUserId(Auth::user()->id);
        $budgetCategories = $budgetCategoryRepository->getByUserId(Auth::user()->id);

        return view('transactions.create', compact('transaction', 'creditCards', 'categories', 'budgetCategories'));
    }

    public function store(
        TransactionRequest $request,
        TransactionService $service
    ) {
        $data = $request->validated();
        $service->store($data);

        return redirect()->route('transactions.create')
            ->with('successMessage', 'Transação cadastrada com sucesso!');
    }

    public function edit(
        Transaction $transaction,
        CreditCardRepository $creditCardRepository,
        CategoryRepository $categoryRepository,
        BudgetCategoryRepository $budgetCategoryRepository
    ) {
        $creditCards = $creditCardRepository->getByUserId(Auth::user()->id);
        $categories = $categoryRepository->getByUserId(Auth::user()->id);
        $budgetCategories = $budgetCategoryRepository->getByUserId(Auth::user()->id);

        return view('transactions.edit', compact('transaction', 'creditCards', 'categories', 'budgetCategories'));
    }

    public function update(
        Transaction $transaction,
        TransactionRequest $request,
        TransactionService $service
    ) {
        $data = $request->validated();

        $service->update($transaction, $data);

        return redirect()->route('transactions.index')
            ->with('successMessage', 'Transação atualizada com sucesso!');
    }

    public function destroy(Transaction $transaction, TransactionService $service)
    {
        Gate::authorize('destroy', $transaction);

        $service->destroy($transaction);

        return redirect()
            ->route('transactions.index')->with('successMessage', 'Transação excluída com sucesso!');
    }
}
