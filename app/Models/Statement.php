<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    protected $fillable = [
        'account_id',
        'opening_date',
        'closing_date',
        'due_date',
        'payment_date',
        'total_amount',
        'status',
    ];

    protected $casts = [
        'opening_date' => 'date',
        'closing_date' => 'date',
        'due_date' => 'date',
        'payment_date' => 'date',
        'total_amount' => 'decimal:2',
    ];


    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Installment::class);
    }
}
