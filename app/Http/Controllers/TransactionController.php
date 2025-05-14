<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function create()
    {
        $creditCards = Auth::user()->accounts->with('creditCards')->get();
        dd($creditCards);
        return view('transactions.create', compact('creditCards'));
    }
}
