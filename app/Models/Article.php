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
        static::saved(function () {
            Cache::flush();
        });

        static::deleted(function () {
            Cache::flush();
        });
    }
}

