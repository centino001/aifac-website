<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'author',
        'content',
        'excerpt',
        'categories',
        'images',
        'published_date',
    ];

    protected $casts = [
        'images' => 'array',
        'categories' => 'array',
        'published_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = \Str::slug($news->title);
            }
        });
    }

    public function getFirstImageAttribute()
    {
        $images = $this->images;

        if (is_array($images) && count($images) > 0) {
            return $images[0];
        }

        return null;
    }

    /** Featured image for cards and detail: thumbnail or first image from gallery */
    public function getFeaturedImageAttribute()
    {
        if (!empty($this->thumbnail)) {
            return $this->thumbnail;
        }
        return $this->first_image;
    }

    /** Excerpt for listing: use stored excerpt or strip HTML from content */
    public function getExcerptAttribute()
    {
        $stored = $this->attributes['excerpt'] ?? null;
        if (!empty($stored)) {
            return \Str::limit($stored, 200);
        }
        $text = strip_tags($this->content);
        return \Str::limit($text, 200);
    }

    public function getFormattedDateAttribute()
    {
        return $this->published_date->format('M d, Y');
    }

    /** Full month day, year for detail page */
    public function getLongDateAttribute()
    {
        return $this->published_date->format('F j, Y');
    }

    /** Estimated read time in minutes */
    public function getReadTimeAttribute()
    {
        $text = strip_tags($this->content);
        $words = str_word_count($text);
        return max(1, (int) ceil($words / 200));
    }
}
