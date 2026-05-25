<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'productsCount' => Product::query()->count(),
            'popularProductsCount' => Product::query()->where('is_popular', true)->count(),
            'categoriesCount' => Category::query()->count(),
        ]);
    }
}
