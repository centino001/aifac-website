<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = ['name', 'email', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
