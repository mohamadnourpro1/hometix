@extends('layouts.admin')

@section('content')
    <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">المنتجات</h1>
            <p class="text-sm text-slate-600">إنشاء وإدارة كتالوج المنتجات.</p>
        </div>

        <a href="{{ route('admin.products.create') }}" class="btn-primary">إضافة منتج</a>
    </div>

    <div class="section-card mb-4">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col gap-2 sm:flex-row">
            <input type="text" name="q" value="{{ $search }}" placeholder="ابحث بالاسم أو الوصف المختصر..." class="input-control">
            <button type="submit" class="btn-primary sm:w-auto">بحث</button>
            @if($search !== '')
                <a href="{{ route('admin.products.index') }}" class="btn-outline sm:w-auto">إعادة ضبط</a>
            @endif
        </form>
    </div>

    <div class="section-card overflow-x-auto">
        <table class="min-w-full text-right text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500">
                    <th class="px-2 py-2 font-medium">الصورة</th>
                    <th class="px-2 py-2 font-medium">الاسم</th>
                    <th class="px-2 py-2 font-medium">التصنيف</th>
                    <th class="px-2 py-2 font-medium">السعر</th>
                    <th class="px-2 py-2 font-medium">شائع</th>
                    <th class="px-2 py-2 font-medium">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="border-b border-slate-100">
                        <td class="px-2 py-3">
                            @if($product->primary_image_url)
                                <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" class="h-12 w-12 rounded object-cover">
                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded bg-slate-100 text-xs text-slate-500">لا يوجد</div>
                            @endif
                        </td>
                        <td class="px-2 py-3 font-medium">{{ $product->name }}</td>
                        <td class="px-2 py-3 text-slate-600">{{ $product->category->name }}</td>
                        <td class="px-2 py-3 text-slate-600">{{ number_format((float) $product->price, 2) }} $</td>
                        <td class="px-2 py-3">
                            @if($product->is_popular)
                                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">نعم</span>
                            @else
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-500">لا</span>
                            @endif
                        </td>
                        <td class="px-2 py-3">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn-outline !px-3 !py-1.5">تعديل</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا المنتج؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-semibold text-red-600 hover:bg-red-50">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-2 py-6 text-center text-slate-500">لا توجد منتجات بعد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection
