<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Statement;
use App\Repositories\StatementRepository;
use Illuminate\Support\Facades\Gate;

class StatementController extends Controller
{
    public function index(Account $account)
    {
        Gate::authorize('statements', $account);
        $statements = $account->statements()->orderBy('opening_date')->get();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('statements.index', compact('statements', 'mensagemSucesso'));
    }

    public function pay(Account $account, Statement $statement, StatementRepository $statementRepository)
    {
        Gate::authorize('statements', $account);

        $statementRepository->pay($statement);

        return redirect()->route('accounts.statements.index', $account)->with('mensagem.sucesso', 'Conta paga com sucesso!');
    }
}
