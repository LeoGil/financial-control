<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getByUserId(int $userId) {
        return Category::where('user_id', $userId)->orWhereNull('user_id')->orderBy('name')->get();
    }
}
