<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    protected $fillable = [
        'name',
        'closing_day',
        'due_day',
        'credit_limit',
        'account_id'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
