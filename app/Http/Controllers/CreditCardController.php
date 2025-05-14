<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditCardRequest;
use App\Models\Account;
use App\Models\CreditCard;
use Illuminate\Support\Facades\Gate;

class CreditCardController extends Controller
{
    public function index(Account $account)
    {
        Gate::authorize('creditCards', $account);
        $creditCards = $account->creditCards;
        $mensagemSucesso = session('mensagem.sucesso');

        return view('credit_cards.index', compact('creditCards', 'mensagemSucesso', 'account'));
    }

    public function create()
    {
        $accounts = Account::all();
        return view('credit_cards.create', compact('accounts'));
    }

    public function store(CreditCardRequest $request)
    {
        CreditCard::create($request->all());

        return redirect()->route('accounts.credit_cards.index', $request->account_id)
            ->with('mensagem.sucesso', 'Cartão cadastrado com sucesso!');
    }

    public function destroy(CreditCard $creditCard)
    {
        $creditCard->delete();

        return redirect()->route('accounts.credit_cards.index', $creditCard->account_id)
            ->with('mensagem.sucesso', 'Cartão excluido com sucesso!');
    }
}
