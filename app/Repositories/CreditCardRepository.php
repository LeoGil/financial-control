<?php

namespace App\Repositories;

use App\Models\CreditCard;

class CreditCardRepository
{
    public function create(array $data) {
        return CreditCard::create($data);
    }
    public function getByUserId(int $userId) {
        return CreditCard::whereHas('account', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();
    }

    public function getById(int $id) {
        return CreditCard::find($id);
    }
}
