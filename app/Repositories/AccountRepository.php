<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountRepository
{
    public function getByUserId(int $userId)
    {
        return Account::where('user_id', $userId)->get();
    }

    public function getUserAccountsWithOldestOpenStatement()
    {
        return Auth::user()
            ->accounts()
            ->with('oldestOpenStatement')
            ->get();
    }
}
