<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'images',
        'is_active',
        'accepts_donations',
        'goals',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'accepts_donations' => 'boolean',
        'goals' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getFirstImageAttribute()
    {
        $images = $this->images;
        
        // Ensure images is an array and has items
        if (is_array($images) && count($images) > 0) {
            return $images[0];
        }
        
        return null;
    }

    public function getFormattedGoalsAttribute()
    {
        if (!$this->goals) {
            return null;
        }
        
        return '₦' . number_format($this->goals, 2);
    }

    public function getGoalsInNairaAttribute()
    {
        return $this->goals ? $this->goals : 0;
    }

    public function getImageCountAttribute()
    {
        $images = $this->images;
        return is_array($images) ? count($images) : 0;
    }
}
