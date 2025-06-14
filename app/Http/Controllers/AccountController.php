<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Repositories\StatementRepository;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index(AccountRepository $accountRepository, StatementRepository $statementRepository)
    {
        $accounts = $accountRepository->getUserAccountsWithOldestOpenStatement();

        $totalOpen = $statementRepository->getTotalByStatus(['open', 'closed'], Auth::id());
        $totalOverdue = $statementRepository->getTotalByStatus(['overdue'], Auth::id());
        $totalPaid = $statementRepository->getTotalPaidThisMonth(Auth::id());
        $nextDueDateFormatted = $statementRepository->getNextDueDate(Auth::id()) ?? '-';

        return view('accounts.index', compact(
            'accounts',
            'totalOpen',
            'totalOverdue',
            'totalPaid',
            'nextDueDateFormatted'
        ));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(AccountRequest $request)
    {
        $data = $request->validated();

        $account = Account::create($data);

        return redirect()->route('accounts.credit_cards.create', $account->id)
            ->with('successMessage', "Conta criada com sucesso! Agora cadastre um cartão de crédito para conseguir realizar transações.");
    }
}
