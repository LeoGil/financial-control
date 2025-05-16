<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository
{
    public function getByUserId(int $userId)
    {
        return Account::where('user_id', $userId)->get();
    }
}
