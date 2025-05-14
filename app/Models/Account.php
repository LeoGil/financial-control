<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Account extends Model
{
    protected $fillable = [
        'name',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function creditCards()
    {
        return $this->hasMany(CreditCard::class);
    }

    public function statements()
    {
        return $this->hasMany(Statement::class);
    }

    protected static function booted()
    {
        static::creating(function (Account $account) {
            $account->user_id = Auth::user()->id;
        });
    }
}
