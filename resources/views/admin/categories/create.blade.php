@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold">إضافة تصنيف</h1>
        <p class="text-sm text-slate-600">أضف تصنيفًا جديدًا للمنتجات.</p>
    </div>

    <div class="section-card">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @include('admin.categories._form', ['submitLabel' => 'إضافة'])
        </form>
    </div>
@endsection
