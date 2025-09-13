<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'image_url', 'description', 'is_donation', 'goal'];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }
}
