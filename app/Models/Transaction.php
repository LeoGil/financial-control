<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'statement_id',
        'credit_card_id',
        'date',
        'name',
        'description',
        'amount',
        'category_id',
        'subcategory_id',
        'budget_category_id',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function creditCard()
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function subcategory()
    // {
    //     return $this->belongsTo(Subcategory::class);
    // }

    public function budgetCategory()
    {
        return $this->belongsTo(BudgetCategory::class);
    }

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }
}
