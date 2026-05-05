<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'description', 'price',
        'image', 'is_seasonal', 'is_pickup',
        'published_at', 'unpublished_at',
    ];

    protected $casts = [
        'is_seasonal'     => 'boolean',
        'is_pickup'       => 'boolean',
        'published_at'    => 'datetime',
        'unpublished_at'  => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        $now = now();
        return $query
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', $now))
            ->where(fn ($q) => $q->whereNull('unpublished_at')->orWhere('unpublished_at', '>', $now));
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
