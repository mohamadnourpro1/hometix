@extends('layouts.app')

@section('content')
    @php
        $whatsAppNumber = preg_replace('/\D+/', '', (string) config('store.whatsapp_number'));
        $heroText = rawurlencode('مرحبًا، أريد الاستفسار عن منتجات HOMETIX');
        $heroWhatsAppUrl = $whatsAppNumber ? "https://wa.me/{$whatsAppNumber}?text={$heroText}" : null;
    @endphp

    <section class="hero-gradient mb-5 overflow-hidden rounded-3xl p-5 text-white shadow-lg md:p-7">
        <p class="mb-2 text-xs tracking-[0.15em] text-brand-100">HOMETIX | متجر إلكترونيات وكهرباء</p>
        <h1 class="mb-2 text-2xl font-bold leading-tight md:text-3xl">كل ما تحتاجه من القطع الإلكترونية والكهربائية في مكان واحد</h1>
        <p class="max-w-2xl text-sm text-brand-100 md:text-base">
            اكتشف منتجات مختارة بعناية لمشاريعك، صيانة منزلك، وحلول المنزل الذكي.
        </p>

        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('products.index') }}" class="btn-primary">تصفح المنتجات</a>
            @if($heroWhatsAppUrl)
                <a href="{{ $heroWhatsAppUrl }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp">تواصل معنا</a>
            @endif
        </div>
    </section>

    <section class="mb-5">
        @include('partials.product-filters', ['action' => route('home')])
    </section>

    @if($popularProducts->isNotEmpty())
        <section class="mb-6 section-card">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">المنتجات الشائعة</h2>

                <div class="hidden items-center gap-2 sm:flex">
                    <button type="button" class="js-popular-prev rounded-lg border border-slate-300 px-3 py-1 text-sm text-slate-700 hover:bg-slate-100">السابق</button>
                    <button type="button" class="js-popular-next rounded-lg border border-slate-300 px-3 py-1 text-sm text-slate-700 hover:bg-slate-100">التالي</button>
                </div>
            </div>

            <div class="swiper js-popular-swiper">
                <div class="swiper-wrapper">
                    @foreach($popularProducts as $product)
                        <div class="swiper-slide pb-1">
                            <x-product-card :product="$product" />
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="js-popular-pagination mt-3"></div>
        </section>
    @endif

    <section>
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">أحدث المنتجات</h2>
            <a href="{{ route('products.index', request()->query()) }}" class="text-sm font-semibold text-brand-700 hover:text-brand-600">عرض كل المنتجات</a>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @forelse($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="section-card col-span-full text-center text-sm text-slate-600">
                    لا توجد منتجات مطابقة للفلاتر الحالية.
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $products->links() }}
        </div>
    </section>
@endsection
