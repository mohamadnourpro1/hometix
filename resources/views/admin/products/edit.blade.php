@extends('layouts.admin')

@section('content')
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <div>
            <h1 class="text-2xl font-bold">تعديل المنتج</h1>
            <p class="text-sm text-slate-600">{{ $product->name }}</p>
        </div>
        <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn-outline">معاينة</a>
    </div>

    <div class="section-card">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.products._form', ['submitLabel' => 'حفظ التعديلات'])
        </form>
    </div>
@endsection
