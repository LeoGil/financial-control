<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreditCardRequest;
use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditCardController extends Controller
{
    public function index()
    {
        $creditCards = CreditCard::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('credit_cards.index', compact('creditCards', 'mensagemSucesso'));
    }

    public function create()
    {
        return view('credit_cards.create');
    }

    public function store(CreditCardRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;

        CreditCard::create($data);

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
