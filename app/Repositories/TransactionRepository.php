<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function getByUserId($userId, int $perPage = 10, $search = null)
    {
        return Transaction::whereHas('creditCard', function ($query) use ($userId) {
            $query->join('accounts', 'accounts.id', '=', 'credit_cards.account_id');
            $query->where('user_id', $userId);
        })
            ->when($search, function ($query) use ($search) {
                $query->where('transactions.name', 'like', '%' . $search . '%');
            })
            ->with('category')
            ->with('installments')
            ->with('creditCard')
            ->orderBy('date', 'desc')
            ->paginate($perPage)
            ->withQueryString();
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
