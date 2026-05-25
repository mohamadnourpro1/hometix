@extends('layouts.app')

@section('content')
    <section class="mb-5">
        <h1 class="mb-2 text-2xl font-bold text-slate-900">المنتجات</h1>
        <p class="text-sm text-slate-600">ابحث وفلتر المنتجات الإلكترونية والكهربائية بسهولة وسرعة.</p>
    </section>

    <section class="mb-5">
        @include('partials.product-filters', ['action' => route('products.index')])
    </section>

    <section>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="section-card col-span-full text-center text-sm text-slate-600">
                    لا توجد منتجات مطابقة.
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $products->links() }}
        </div>
    </section>
@endsection
