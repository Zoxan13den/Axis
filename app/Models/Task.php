<?php

namespace App\Models;

class Task extends Model
{
    protected $fillable = ['project_id', 'name', 'description', 'priority',	'status', 'deadline'];

    protected $casts = [
    ];

    protected $guarded = ['id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
