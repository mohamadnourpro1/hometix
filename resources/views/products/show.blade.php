@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="text-sm font-medium text-brand-700 hover:text-brand-600">رجوع</a>
    </div>

    <section class="grid gap-4 lg:grid-cols-2">
        <div class="section-card overflow-hidden">
            @php
                $hasMedia = $product->images->isNotEmpty() || $videoEmbeds->isNotEmpty();
            @endphp

            @if($hasMedia)
                <div class="swiper js-media-swiper">
                    <div class="swiper-wrapper">
                        @foreach($product->images as $image)
                            <div class="swiper-slide overflow-hidden rounded-2xl">
                                <div class="aspect-[4/3] w-full overflow-hidden rounded-2xl bg-slate-100 sm:aspect-video">
                                    <img src="{{ $image->url }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover">
                                </div>
                            </div>
                        @endforeach

                        @foreach($videoEmbeds as $embedUrl)
                            <div class="swiper-slide overflow-hidden rounded-2xl bg-black">
                                <div class="aspect-[4/3] w-full overflow-hidden rounded-2xl bg-black sm:aspect-video">
                                    <iframe
                                        src="{{ $embedUrl }}"
                                        class="h-full w-full"
                                        loading="lazy"
                                        title="فيديو يوتيوب"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen
                                    ></iframe>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-3 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center justify-between gap-2">
                        <button type="button" class="js-media-prev w-1/2 rounded-lg border border-slate-300 px-3 py-2 text-xs hover:bg-slate-100 sm:w-auto sm:text-sm">السابق</button>
                        <button type="button" class="js-media-next w-1/2 rounded-lg border border-slate-300 px-3 py-2 text-xs hover:bg-slate-100 sm:w-auto sm:text-sm">التالي</button>
                    </div>
                    <div class="js-media-pagination flex justify-center sm:justify-end"></div>
                </div>
            @else
                <div class="flex h-[320px] items-center justify-center rounded-2xl bg-slate-100 text-sm text-slate-500">
                    لا توجد وسائط لهذا المنتج.
                </div>
            @endif
        </div>

        <div class="section-card">
            <div class="mb-2">
                <span class="inline-flex rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">
                    {{ $product->category->name }}
                </span>
            </div>

            <h1 class="mb-3 text-2xl font-bold text-slate-900">{{ $product->name }}</h1>
            <div class="mb-4">
                <p class="text-xs font-semibold text-slate-500">السعر</p>
                <p class="text-2xl font-bold text-brand-700">{{ number_format((float) $product->price, 2) }} $</p>
            </div>

            <div class="mb-4">
                <p class="mb-1 text-xs font-semibold text-slate-500">وصف مختصر</p>
                <p class="text-sm text-slate-700">{{ $product->short_description }}</p>
            </div>

            @if($product->description)
                <div class="mb-5">
                    <p class="mb-2 text-xs font-semibold text-slate-500">الوصف</p>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm leading-7 text-slate-700">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
            @endif

            @if($whatsAppUrl)
                <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp w-full">
                    استفسر عبر واتساب
                </a>
            @else
                <p class="rounded-xl border border-amber-200 bg-amber-50 p-3 text-sm text-amber-800">
                    رقم واتساب غير مضاف بعد.
                </p>
            @endif
        </div>
    </section>
@endsection
