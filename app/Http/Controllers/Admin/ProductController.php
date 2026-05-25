<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('q'));

        $products = Product::query()
            ->with(['category', 'images'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $product = null;

        DB::transaction(function () use ($request, $validated, &$product) {
            $product = Product::query()->create([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'price' => $validated['price'],
                'price_usd' => $validated['price_usd'] ?? null,
                'price_try' => $validated['price_try'] ?? null,
                'price_syp' => $validated['price_syp'] ?? null,
                'short_description' => $validated['short_description'],
                'description' => $validated['description'] ?? null,
                'is_popular' => $validated['is_popular'] ?? false,
            ]);

            $this->storeProductImages($product, (array) $request->file('images', []));
            $this->storeProductVideos($product, $validated['youtube_urls'] ?? []);
        });

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'تم إضافة المنتج بنجاح.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product->load(['images', 'videos', 'category']),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated, $product) {
            $product->update([
                'category_id' => $validated['category_id'],
                'name' => $validated['name'],
                'price' => $validated['price'],
                'price_usd' => $validated['price_usd'] ?? null,
                'price_try' => $validated['price_try'] ?? null,
                'price_syp' => $validated['price_syp'] ?? null,
                'short_description' => $validated['short_description'],
                'description' => $validated['description'] ?? null,
                'is_popular' => $validated['is_popular'] ?? false,
            ]);

            $removeImageIds = collect($validated['remove_image_ids'] ?? [])->map(fn ($id) => (int) $id)->all();
            if (count($removeImageIds) > 0) {
                $imagesToRemove = $product->images()->whereIn('id', $removeImageIds)->get();
                foreach ($imagesToRemove as $image) {
                    if ($image->image_path && ! str_starts_with($image->image_path, 'http')) {
                        Storage::disk('public')->delete($image->image_path);
                    }
                }
                $product->images()->whereIn('id', $removeImageIds)->delete();
            }

            $removeVideoIds = collect($validated['remove_video_ids'] ?? [])->map(fn ($id) => (int) $id)->all();
            if (count($removeVideoIds) > 0) {
                $product->videos()->whereIn('id', $removeVideoIds)->delete();
            }

            $this->storeProductImages($product, (array) $request->file('images', []));
            $this->storeProductVideos($product, $validated['youtube_urls'] ?? []);
        });

        return back()->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product) {
            $product->load('images');

            foreach ($product->images as $image) {
                if ($image->image_path && ! str_starts_with($image->image_path, 'http')) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }

            $product->delete();
        });

        return back()->with('success', 'تم حذف المنتج بنجاح.');
    }

    private function storeProductImages(Product $product, array $images): void
    {
        foreach ($images as $image) {
            $path = $image->store("products/{$product->id}", 'public');

            $product->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    private function storeProductVideos(Product $product, array $urls): void
    {
        $links = collect($urls)
            ->map(fn ($url) => trim((string) $url))
            ->filter()
            ->values();

        foreach ($links as $url) {
            $product->videos()->create([
                'youtube_url' => $url,
            ]);
        }
    }
}
