<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'price_usd',
        'price_try',
        'price_syp',
        'short_description',
        'description',
        'is_popular',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_usd' => 'decimal:2',
        'price_try' => 'decimal:2',
        'price_syp' => 'decimal:2',
        'is_popular' => 'boolean',
    ];

    protected $appends = [
        'primary_image_url',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if ($product->isDirty('name')) {
                $product->slug = self::generateUniqueSlug($product->name, $product->id);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(ProductVideo::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $search = trim((string) ($filters['q'] ?? ''));
        $categorySlug = $filters['category'] ?? null;
        $minPrice = $filters['min_price'] ?? null;
        $maxPrice = $filters['max_price'] ?? null;
        $popularOnly = (string) ($filters['popular'] ?? '') === '1';
        $sort = $filters['sort'] ?? 'newest';

        return $query
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $searchQuery) use ($search) {
                    $searchQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categorySlug, function (Builder $query, string $categorySlug) {
                $query->whereHas('category', fn (Builder $categoryQuery) => $categoryQuery->where('slug', $categorySlug));
            })
            ->when($minPrice !== null && $minPrice !== '', fn (Builder $query) => $query->where('price', '>=', (float) $minPrice))
            ->when($maxPrice !== null && $maxPrice !== '', fn (Builder $query) => $query->where('price', '<=', (float) $maxPrice))
            ->when($popularOnly, fn (Builder $query) => $query->where('is_popular', true))
            ->when($sort === 'price_asc', fn (Builder $query) => $query->orderBy('price'))
            ->when($sort === 'price_desc', fn (Builder $query) => $query->orderByDesc('price'))
            ->when(! in_array($sort, ['price_asc', 'price_desc'], true), fn (Builder $query) => $query->latest());
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $image = $this->images->first();

        if (! $image) {
            return null;
        }

        return $image->url;
    }

    private static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'product';

        $slug = $baseSlug;
        $counter = 1;

        while (
            self::query()
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
