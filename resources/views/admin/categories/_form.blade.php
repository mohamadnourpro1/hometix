@csrf

<div class="space-y-4">
    <div>
        <label for="name" class="mb-1 block text-sm font-semibold text-slate-700">اسم التصنيف</label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" class="input-control" required>
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-2">
        <button type="submit" class="btn-primary">{{ $submitLabel }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn-outline">إلغاء</a>
    </div>
</div>
