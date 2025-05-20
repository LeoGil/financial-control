<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function destroy(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->creditCard->account->user_id;
    }
}
