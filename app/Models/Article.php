<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'image',
        'detail_image',
        'category',
        'read_time',
        'content',
        'published_at'
    ];

    protected static function booted()
    {
        static::saving(function ($article) {
            if (empty($article->read_time) && !empty($article->content)) {
                $words = count(preg_split('/\s+/', trim(strip_tags($article->content))));
                $minutes = max(1, (int) ceil($words / 150));
                $article->read_time = $minutes . ' menit';
            }
        });

        static::saved(function () {
            Cache::flush();
        });

        static::deleted(function () {
            Cache::flush();
        });
    }
}

