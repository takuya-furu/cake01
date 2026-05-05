<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'published_at', 'unpublished_at'];

    protected $casts = [
        'published_at'   => 'datetime',
        'unpublished_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        $now = now();
        return $query
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', $now))
            ->where(fn ($q) => $q->whereNull('unpublished_at')->orWhere('unpublished_at', '>', $now));
    }

    // 保存時にサーバーサイドでHTMLをサニタイズ (XSS対策)
    public function setBodyAttribute(string $value): void
    {
        $this->attributes['body'] = Purify::clean($value);
    }
}
