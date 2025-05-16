<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function store($data)
    {
        return Transaction::create($data);
    }

    public function delete(Transaction $transaction): void
    {
        $transaction->delete();
    }
}
