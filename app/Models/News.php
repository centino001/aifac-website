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
        'content',
        'images',
        'published_date',
    ];

    protected $casts = [
        'images' => 'array',
        'published_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Accessor to get the first image safely
    public function getFirstImageAttribute()
    {
        $images = $this->images;
        
        if (is_array($images) && count($images) > 0) {
            return $images[0];
        }
        
        return null;
    }

    // Accessor to get excerpt for listing
    public function getExcerptAttribute()
    {
        return \Str::limit($this->content, 150);
    }

    // Accessor to format published date
    public function getFormattedDateAttribute()
    {
        return $this->published_date->format('M d, Y');
    }
}
