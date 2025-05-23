<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Account extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'closing_day',
        'due_day'
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

    public function oldestOpenStatement(): HasOne
    {
        return $this->hasOne(Statement::class)->ofMany(
            [
                'opening_date' => 'min'
            ],
            function (Builder $query) {
                $query->where('status', 'open');
            }
        );
    }

    protected static function booted()
    {
        static::creating(function (Account $account) {
            $account->user_id = Auth::user()->id;
        });
    }
}
