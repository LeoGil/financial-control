<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Account;
use App\Models\Statement;
use App\Models\Transaction;
use App\Repositories\BudgetCategoryRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CreditCardRepository;
use App\Repositories\StatementRepository;
use App\Repositories\TransactionRepository;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Account $account, Statement $statement, StatementRepository $statementRepository)
    {
        Gate::authorize('statements', $account);

        $installments = $statementRepository->getInstallments($statement);

        $mensagemSucesso = session('mensagem.sucesso');

        return view('transactions.index', compact('installments', 'account', 'mensagemSucesso'));
    }

    public function create(
        CreditCardRepository $creditCardRepository,
        CategoryRepository $categoryRepository,
        BudgetCategoryRepository $budgetCategoryRepository
    ) {
        $creditCards = $creditCardRepository->getByUserId(Auth::user()->id);
        $categories = $categoryRepository->getByUserId(Auth::user()->id);
        $budgetCategories = $budgetCategoryRepository->getByUserId(Auth::user()->id);

        return view('transactions.create', compact('creditCards', 'categories', 'budgetCategories'));
    }

    public function store(
        TransactionRequest $request,
        TransactionService $service
    ) {
        $data = $request->validated();
        $service->store($data);

        return redirect()->route('transactions.create');
    }

    public function destroy(
        Account $account,
        Transaction $transaction,
        TransactionService $service
    ) {
        Gate::authorize('statements', $account);

        $service->destroy($transaction);

        return redirect()
            ->route('accounts.statements.index', $account)
            ->with('mensagem.sucesso', 'Transação excluída com sucesso!');
    }
}
