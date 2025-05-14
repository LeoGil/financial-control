<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'transaction_id',
        'statement_id',
        'installment_number',
        'installment_total',
        'amount',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function statement()
    {
        return $this->belongsTo(Statement::class);
    }
}
