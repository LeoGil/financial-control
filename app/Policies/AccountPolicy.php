<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;

class AccountPolicy
{
    public function creditCards(User $user, Account $account): bool
    {
        return $user->id === $account->user_id;
    }

    public function statements(User $user, Account $account): bool
    {
        return $user->id === $account->user_id;
    }

    public function delete(User $user, Account $account): bool
    {
        return $user->id === $account->user_id;
    }
}
