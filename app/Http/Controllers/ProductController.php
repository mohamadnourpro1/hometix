<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductController extends Controller
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

        $products = Product::query()
            ->with(['category', 'images'])
            ->filter($filters)
            ->paginate(16)
            ->withQueryString();

        return view('products.index', [
            'categories' => $categories,
            'products' => $products,
            'filters' => $filters,
        ]);
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'videos']);

        $videoEmbeds = $product->videos
            ->map(fn ($video) => $video->embed_url)
            ->filter()
            ->values();

        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('store.whatsapp_number'));
        $whatsAppMessage = sprintf('مرحبًا، أريد الاستفسار عن المنتج: %s', $product->name);
        $whatsAppUrl = $whatsAppNumber
            ? sprintf('https://wa.me/%s?text=%s', $whatsAppNumber, rawurlencode($whatsAppMessage))
            : null;

        return view('products.show', [
            'product' => $product,
            'videoEmbeds' => $videoEmbeds,
            'whatsAppUrl' => $whatsAppUrl,
        ]);
    }
}
