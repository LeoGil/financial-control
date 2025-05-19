<?php

namespace App\Policies;

use App\Models\CreditCard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CreditCardPolicy
{
    public function delete(User $user, CreditCard $creditCard): bool
    {
        return $user->id === $creditCard->account->user_id;
    }
}
