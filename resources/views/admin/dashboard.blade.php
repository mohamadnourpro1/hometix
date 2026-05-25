@extends('layouts.admin')

@section('content')
    <div class="mb-5">
        <h1 class="text-2xl font-bold">لوحة التحكم</h1>
        <p class="text-sm text-slate-600">نظرة سريعة على مخزون المتجر.</p>
    </div>

    <div class="grid gap-3 sm:grid-cols-3">
        <div class="section-card">
            <p class="text-xs uppercase text-slate-500">المنتجات</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $productsCount }}</p>
        </div>
        <div class="section-card">
            <p class="text-xs uppercase text-slate-500">المنتجات الشائعة</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $popularProductsCount }}</p>
        </div>
        <div class="section-card">
            <p class="text-xs uppercase text-slate-500">التصنيفات</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $categoriesCount }}</p>
        </div>
    </div>
@endsection
