@php
    $editing = isset($product);
    $youtubeInputs = old('youtube_urls', ['']);
@endphp

@csrf

<div class="grid gap-4 md:grid-cols-2">
    <div class="md:col-span-2">
        <label for="name" class="mb-1 block text-sm font-semibold text-slate-700">اسم المنتج</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" class="input-control" required>
        @error('name')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category_id" class="mb-1 block text-sm font-semibold text-slate-700">التصنيف</label>
        <select name="category_id" id="category_id" class="input-control" required>
            <option value="">اختر التصنيف</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id ?? '') === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price" class="mb-1 block text-sm font-semibold text-slate-700">السعر</label>
        <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" class="input-control" required>
        @error('price')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

        <div>
        <label for="price_usd" class="mb-1 block text-sm font-semibold text-slate-700">السعر بالدولار (USD)</label>
        <input type="number" step="0.01" min="0" name="price_usd" id="price_usd" value="{{ old('price_usd', $product->price_usd ?? '') }}" class="input-control">
        @error('price_usd')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price_try" class="mb-1 block text-sm font-semibold text-slate-700">السعر بالليرة التركية (TRY)</label>
        <input type="number" step="0.01" min="0" name="price_try" id="price_try" value="{{ old('price_try', $product->price_try ?? '') }}" class="input-control">
        @error('price_try')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price_syp" class="mb-1 block text-sm font-semibold text-slate-700">السعر بالليرة السورية (SYP)</label>
        <input type="number" step="0.01" min="0" name="price_syp" id="price_syp" value="{{ old('price_syp', $product->price_syp ?? '') }}" class="input-control">
        @error('price_syp')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
<div class="md:col-span-2">
        <label for="short_description" class="mb-1 block text-sm font-semibold text-slate-700">وصف مختصر</label>
        <textarea name="short_description" id="short_description" rows="3" class="input-control" required>{{ old('short_description', $product->short_description ?? '') }}</textarea>
        @error('short_description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label for="description" class="mb-1 block text-sm font-semibold text-slate-700">الوصف الكامل</label>
        <textarea name="description" id="description" rows="6" class="input-control">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm">
            <input type="checkbox" name="is_popular" value="1" @checked(old('is_popular', $product->is_popular ?? false)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
            وضع علامة (شائع)
        </label>
    </div>

    <div class="md:col-span-2">
        <label for="images" class="mb-1 block text-sm font-semibold text-slate-700">رفع صور المنتج</label>
        <input type="file" name="images[]" id="images" multiple accept=".jpg,.jpeg,.png,.webp" class="input-control">
        @error('images')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
        @error('images.*')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if($editing && $product->images->isNotEmpty())
        <div class="md:col-span-2 rounded-xl border border-slate-200 p-3">
            <p class="mb-2 text-sm font-semibold text-slate-800">الصور الحالية</p>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                @foreach($product->images as $image)
                    <label class="space-y-2 text-xs text-slate-600">
                        <img src="{{ $image->url }}" alt="صورة المنتج" class="aspect-square w-full rounded-lg object-cover">
                        <span class="inline-flex items-center gap-2">
                            <input type="checkbox" name="remove_image_ids[]" value="{{ $image->id }}" class="rounded border-slate-300">
                            حذف
                        </span>
                    </label>
                @endforeach
            </div>
            @error('remove_image_ids.*')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif

    <div class="md:col-span-2 rounded-xl border border-slate-200 p-3">
        <div class="mb-2 flex items-center justify-between">
            <p class="text-sm font-semibold text-slate-800">إضافة روابط يوتيوب</p>
            <button type="button" data-add-youtube class="rounded-lg border border-slate-300 px-2.5 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-100">إضافة حقل</button>
        </div>

        <div class="space-y-2" data-youtube-wrapper>
            @foreach($youtubeInputs as $youtubeInput)
                <input type="url" name="youtube_urls[]" value="{{ $youtubeInput }}" placeholder="https://www.youtube.com/watch?v=..." class="input-control">
            @endforeach
        </div>
        @error('youtube_urls.*')
            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if($editing && $product->videos->isNotEmpty())
        <div class="md:col-span-2 rounded-xl border border-slate-200 p-3">
            <p class="mb-2 text-sm font-semibold text-slate-800">روابط يوتيوب الحالية</p>
            <div class="space-y-2">
                @foreach($product->videos as $video)
                    <label class="flex items-center gap-2 text-sm text-slate-700">
                        <input type="checkbox" name="remove_video_ids[]" value="{{ $video->id }}" class="rounded border-slate-300">
                        <a href="{{ $video->youtube_url }}" target="_blank" rel="noopener noreferrer" class="text-brand-700 hover:text-brand-600">{{ $video->youtube_url }}</a>
                        <span class="text-xs text-slate-500">(حذف)</span>
                    </label>
                @endforeach
            </div>
            @error('remove_video_ids.*')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @endif
</div>

<div class="mt-5 flex gap-2">
    <button type="submit" class="btn-primary">{{ $submitLabel }}</button>
    <a href="{{ route('admin.products.index') }}" class="btn-outline">إلغاء</a>
</div>
