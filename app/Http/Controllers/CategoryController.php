<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->getByUserId(Auth::user()->id);

        return view('categories.index', compact('categories'));
    }
}
