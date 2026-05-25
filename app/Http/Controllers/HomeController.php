<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only([
            'q',
            'category',
            'min_price',
            'max_price',
            'popular',
            'sort',
        ]);

        $categories = Category::query()->orderBy('name')->get();
        $popularProducts = Product::query()
            ->with('images')
            ->where('is_popular', true)
            ->latest()
            ->take(10)
            ->get();

        $products = Product::query()
            ->with(['category', 'images'])
            ->filter($filters)
            ->paginate(12)
            ->withQueryString();

        return view('home', [
            'categories' => $categories,
            'popularProducts' => $popularProducts,
            'products' => $products,
            'filters' => $filters,
        ]);
    }
}
