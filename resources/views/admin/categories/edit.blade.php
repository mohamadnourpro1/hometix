@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <h1 class="text-2xl font-bold">تعديل التصنيف</h1>
        <p class="text-sm text-slate-600">تحديث بيانات التصنيف.</p>
    </div>

    <div class="section-card">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @method('PUT')
            @include('admin.categories._form', ['submitLabel' => 'حفظ التعديلات'])
        </form>
    </div>
@endsection
