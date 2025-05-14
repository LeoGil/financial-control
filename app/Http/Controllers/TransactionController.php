<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Repositories\BudgetCategoryRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CreditCardRepository;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
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
}
