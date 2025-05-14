<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Auth::user()->accounts;
        $mensagemSucesso = session('mensagem.sucesso');

        return view('accounts.index', compact('accounts', 'mensagemSucesso'));
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
