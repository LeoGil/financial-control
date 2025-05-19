<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditCardRequest;
use App\Models\Account;
use App\Models\CreditCard;
use App\Repositories\AccountRepository;
use App\Repositories\CreditCardRepository;
use Illuminate\Support\Facades\Auth;
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

    public function create(Account $account)
    {
        Gate::authorize('creditCards', $account);

        return view('credit_cards.create', compact('account'));
    }

    public function store(CreditCardRequest $request, Account $account, CreditCardRepository $creditCardRepository)
    {
        Gate::authorize('creditCards', $account);

        $data = $request->validated();
        $data['account_id'] = $account->id;

        $creditCardRepository->create($data);

        return redirect()->route('accounts.credit_cards.index', $account->id)
            ->with('mensagem.sucesso', 'Cartão cadastrado com sucesso!');
    }

    public function destroy(CreditCard $creditCard)
    {
        Gate::authorize('delete', $creditCard);

        $creditCard->delete();

        return redirect()->route('accounts.credit_cards.index', $creditCard->account_id)
            ->with('mensagem.sucesso', 'Cartão excluido com sucesso!');
    }
}
