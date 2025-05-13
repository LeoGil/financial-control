<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditCardRequest;
use App\Models\Account;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditCardController extends Controller
{
    public function index(Account $account)
    {
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

        return redirect()->route('credit_cards.index')
            ->with('mensagem.sucesso', 'Cartão cadastrado com sucesso!');
    }

    public function destroy(CreditCard $creditCard)
    {
        $creditCard->delete();

        return redirect()->route('credit_cards.index')
            ->with('mensagem.sucesso', 'Cartão excluido com sucesso!');
    }
}
