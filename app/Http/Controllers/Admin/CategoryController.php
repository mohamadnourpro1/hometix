<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withCount('products')
            ->latest()
            ->paginate(15);

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::query()->create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم إضافة التصنيف بنجاح.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            $category->delete();
        } catch (QueryException $exception) {
            return back()->with('error', 'لا يمكن حذف التصنيف لوجود منتجات مرتبطة به.');
        }

        return back()->with('success', 'تم حذف التصنيف بنجاح.');
    }
}
