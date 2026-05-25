@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold">إضافة منتج</h1>
        <p class="text-sm text-slate-600">أضف منتجًا جديدًا مع الصور وروابط يوتيوب (اختياري).</p>
    </div>

    <div class="section-card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.products._form', ['submitLabel' => 'إضافة المنتج'])
        </form>
    </div>
@endsection
