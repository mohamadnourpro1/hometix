<?php

namespace App\Http\Requests;

use App\Rules\ValidYouTubeUrl;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:160'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_usd' => ['nullable', 'numeric', 'min:0'],
            'price_try' => ['nullable', 'numeric', 'min:0'],
            'price_syp' => ['nullable', 'numeric', 'min:0'],
            'short_description' => ['required', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'is_popular' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'youtube_urls' => ['nullable', 'array'],
            'youtube_urls.*' => ['nullable', 'string', 'max:255', new ValidYouTubeUrl()],
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'التصنيف مطلوب.',
            'category_id.exists' => 'التصنيف المحدد غير صحيح.',
            'name.required' => 'اسم المنتج مطلوب.',
            'name.max' => 'اسم المنتج يجب ألا يتجاوز :max حرفًا.',
            'price.required' => 'السعر مطلوب.',
            'price.numeric' => 'السعر يجب أن يكون رقمًا.',
            'price.min' => 'السعر يجب ألا يقل عن :min.',
            'price_usd.numeric' => 'سعر الدولار يجب أن يكون رقمًا.',
            'price_usd.min' => 'سعر الدولار يجب ألا يقل عن :min.',
            'price_try.numeric' => 'سعر الليرة التركية يجب أن يكون رقمًا.',
            'price_try.min' => 'سعر الليرة التركية يجب ألا يقل عن :min.',
            'price_syp.numeric' => 'سعر الليرة السورية يجب أن يكون رقمًا.',
            'price_syp.min' => 'سعر الليرة السورية يجب ألا يقل عن :min.',
            'short_description.required' => 'الوصف المختصر مطلوب.',
            'short_description.max' => 'الوصف المختصر يجب ألا يتجاوز :max حرفًا.',
            'images.*.image' => 'الملف المرفوع يجب أن يكون صورة.',
            'images.*.mimes' => 'صيغة الصورة غير مدعومة. الصيغ المسموحة: jpg, jpeg, png, webp.',
            'images.*.max' => 'حجم الصورة يجب ألا يتجاوز 3MB.',
            'youtube_urls.*.max' => 'رابط يوتيوب طويل جدًا.',
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'التصنيف',
            'name' => 'اسم المنتج',
            'price' => 'السعر',
            'price_usd' => 'السعر بالدولار',
            'price_try' => 'السعر بالليرة التركية',
            'price_syp' => 'السعر بالليرة السورية',
            'short_description' => 'الوصف المختصر',
            'description' => 'الوصف الكامل',
            'images' => 'الصور',
            'youtube_urls' => 'روابط يوتيوب',
        ];
    }

    protected function prepareForValidation(): void
    {
        $youtubeUrls = collect($this->input('youtube_urls', []))
            ->map(fn ($url) => trim((string) $url))
            ->filter()
            ->values()
            ->all();

        $this->merge([
            'is_popular' => $this->boolean('is_popular'),
            'youtube_urls' => $youtubeUrls,
        ]);
    }
}
