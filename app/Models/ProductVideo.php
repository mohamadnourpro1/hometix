<?php

namespace App\Models;

use App\Support\YouTube;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'youtube_url',
    ];

    protected $appends = [
        'embed_url',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getEmbedUrlAttribute(): ?string
    {
        return YouTube::toEmbedUrl($this->youtube_url);
    }
}
