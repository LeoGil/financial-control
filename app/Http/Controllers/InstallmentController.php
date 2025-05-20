<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Statement;
use App\Repositories\StatementRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class InstallmentController extends Controller
{
    public function index(Account $account, Statement $statement, StatementRepository $statementRepository)
    {
        Gate::authorize('installments', $account);
        $mensagemSucesso = session('mensagem.sucesso');

        $installments = $statementRepository->getInstallments($statement);
        
        return view('installments.index', compact('account', 'installments', 'mensagemSucesso'));
    }
}
