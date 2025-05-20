<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function getByUserId($userId, int $perPage = 10)
    {
        return Transaction::whereHas('creditCard', function ($query) use ($userId) {
            $query->join('accounts', 'accounts.id', '=', 'credit_cards.account_id');
            $query->where('user_id', $userId);
        })
            ->with('category')
            ->with('installments')
            ->with('creditCard')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function store($data)
    {
        return Transaction::create($data);
    }

    public function delete(Transaction $transaction): void
    {
        $transaction->delete();
    }
}
