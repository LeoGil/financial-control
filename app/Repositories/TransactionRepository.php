<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository
{
    public function store($data)
    {
        return Transaction::create($data);
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
    }
}
