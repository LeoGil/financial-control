<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Repositories\AccountRepository;
use App\Repositories\StatementRepository;

class AccountController extends Controller
{
    public function index(AccountRepository $accountRepository, StatementRepository $statementRepository)
    {
        $mensagemSucesso = session('mensagem.sucesso');
        $accounts = $accountRepository->getUserAccountsWithOldestOpenStatement();

        $totalOpen = $statementRepository->getTotalByStatus('open');
        $totalOverdue = $statementRepository->getTotalByStatus('overdue');
        $totalPaid = $statementRepository->getTotalPaidThisMonth();
        $nextDueDateFormatted = $statementRepository->getNextDueDate() ?? '-';

        return view('accounts.index', compact(
            'accounts',
            'mensagemSucesso',
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

        Account::create($data);

        return redirect()->route('accounts.index')
            ->with('mensagem.sucesso', 'Conta cadastrada com sucesso!');
    }
}
