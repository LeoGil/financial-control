<?php

namespace App\Repositories;

use App\Models\BudgetCategory;

class BudgetCategoryRepository
{
    public function getByUserId(int $userId)
    {
        return BudgetCategory::where('user_id', $userId)->get();
    }
}
