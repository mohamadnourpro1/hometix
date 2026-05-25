@extends('layouts.admin')

@section('content')
    <div class="mb-4 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold">التصنيفات</h1>
            <p class="text-sm text-slate-600">إدارة تصنيفات المنتجات.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">إضافة تصنيف</a>
    </div>

    <div class="section-card overflow-x-auto">
        <table class="min-w-full text-right text-sm">
            <thead>
                <tr class="border-b border-slate-200 text-slate-500">
                    <th class="px-2 py-2 font-medium">الاسم</th>
                    <th class="px-2 py-2 font-medium">Slug</th>
                    <th class="px-2 py-2 font-medium">عدد المنتجات</th>
                    <th class="px-2 py-2 font-medium">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b border-slate-100">
                        <td class="px-2 py-3 font-medium">{{ $category->name }}</td>
                        <td class="px-2 py-3 text-slate-600">{{ $category->slug }}</td>
                        <td class="px-2 py-3 text-slate-600">{{ $category->products_count }}</td>
                        <td class="px-2 py-3">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-outline !px-3 !py-1.5">تعديل</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('هل تريد حذف هذا التصنيف؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-200 px-3 py-1.5 text-sm font-semibold text-red-600 hover:bg-red-50">حذف</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-2 py-6 text-center text-slate-500">لا توجد تصنيفات بعد.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection
