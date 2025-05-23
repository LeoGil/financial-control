<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountRepository
{
    public function getById(int $id)
    {
        return Account::find($id);
    }

    public function getByUserId(int $userId)
    {
        return Account::where('user_id', $userId)->get();
    }

    public function getByCreditCardId(int $creditCardId)
    {
        return Account::whereHas('creditCards', function ($query) use ($creditCardId) {
            $query->where('credit_cards.id', $creditCardId);
        })->first();
    }

    public function getUserAccountsWithOldestOpenStatement()
    {
        return Auth::user()
            ->accounts()
            ->with('oldestOpenStatement')
            ->get();
    }
}
