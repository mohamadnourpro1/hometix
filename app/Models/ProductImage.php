<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
    ];

    protected $appends = [
        'url',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        $path = (string) $this->image_path;

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        // Use the current app URL (host/port/subdirectory) instead of relying on APP_URL,
        // which is often different in local dev (artisan serve vs Apache, ports, subfolders).
        return asset('storage/'.ltrim($path, '/'));
    }
}
