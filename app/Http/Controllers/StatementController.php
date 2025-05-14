<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Support\Facades\Gate;

class StatementController extends Controller
{
    public function index(Account $account)
    {
        Gate::authorize('statements', $account);
        $statements = $account->statements;
        $mensagemSucesso = session('mensagem.sucesso');

        return view('statements.index', compact('statements', 'mensagemSucesso'));
    }
}
