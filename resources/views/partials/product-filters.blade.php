@php
    $q = $filters['q'] ?? '';
    $category = $filters['category'] ?? '';
    $minPrice = $filters['min_price'] ?? '';
    $maxPrice = $filters['max_price'] ?? '';
    $popular = ($filters['popular'] ?? '') === '1';
    $sort = $filters['sort'] ?? 'newest';
@endphp

<details class="section-card [&_summary::-webkit-details-marker]:hidden" open>
    <summary class="mb-3 flex cursor-pointer items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-800 md:hidden">
        فلترة المنتجات
        <span class="text-xs font-normal text-slate-500">اضغط للإخفاء</span>
    </summary>

    <form method="GET" action="{{ $action }}" class="space-y-3">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="بحث عن منتج..."
                class="input-control lg:col-span-2"
            >

            <select name="category" class="input-control">
                <option value="">كل التصنيفات</option>
                @foreach($categories as $item)
                    <option value="{{ $item->slug }}" @selected($category === $item->slug)>{{ $item->name }}</option>
                @endforeach
            </select>

            <input
                type="number"
                name="min_price"
                value="{{ $minPrice }}"
                min="0"
                step="0.01"
                placeholder="السعر من"
                class="input-control"
            >

            <input
                type="number"
                name="max_price"
                value="{{ $maxPrice }}"
                min="0"
                step="0.01"
                placeholder="السعر إلى"
                class="input-control"
            >
        </div>

        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            <label class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm">
                <input type="checkbox" name="popular" value="1" @checked($popular) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                المنتجات الشائعة فقط
            </label>

            <select name="sort" class="input-control">
                <option value="newest" @selected($sort === 'newest')>الأحدث</option>
                <option value="price_asc" @selected($sort === 'price_asc')>السعر: من الأقل للأعلى</option>
                <option value="price_desc" @selected($sort === 'price_desc')>السعر: من الأعلى للأقل</option>
            </select>

            <button type="submit" class="btn-primary">تطبيق</button>
            <a href="{{ $action }}" class="btn-outline">إعادة ضبط</a>
        </div>
    </form>
</details>
