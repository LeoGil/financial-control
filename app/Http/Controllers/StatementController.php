<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Statement;
use App\Repositories\StatementRepository;
use Illuminate\Support\Facades\Gate;

class StatementController extends Controller
{
    public function index(Account $account, StatementRepository $statementRepository)
    {
        Gate::authorize('statements', $account);
        $statements = $statementRepository->getByAccount($account);

        return view('statements.index', compact('statements'));
    }

    public function pay(Account $account, Statement $statement, StatementRepository $statementRepository)
    {
        Gate::authorize('statements', $account);

        $statementRepository->pay($statement);

        return redirect()->route('accounts.statements.index', $account)->with('successMessage', 'Conta paga com sucesso!');
    }
}
