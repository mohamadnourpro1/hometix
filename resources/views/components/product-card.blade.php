@props(['product'])

<article class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
    <a href="{{ route('products.show', $product->slug) }}" class="block">
        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
            @if($product->primary_image_url)
                <div class="relative h-full w-full">
                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover">
                    @if($product->is_popular)
                        <span class="badge-popular absolute end-3 top-3">شائع</span>
                    @endif
                </div>
            @else
                <div class="flex h-full items-center justify-center px-3 text-center text-xs text-slate-500">
                    لا توجد صورة
                </div>
            @endif
        </div>
    </a>

    <div class="space-y-2 p-3">
        <div class="min-h-[40px] text-sm font-semibold text-slate-900">{{ $product->name }}</div>

        <div class="text-base font-bold text-brand-700">{{ number_format((float) $product->price, 2) }} $</div>

        <p class="min-h-[36px] text-xs text-slate-600">{{ $product->short_description }}</p>

        <a href="{{ route('products.show', $product->slug) }}" class="btn-primary w-full">عرض التفاصيل</a>
    </div>
</article>
