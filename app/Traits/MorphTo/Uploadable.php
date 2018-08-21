<?php 

namespace App\Traits\MorphTo;
use App\Project;

trait Uploadable
{
    public function uploadable()
    {
        return $this->morphTo();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}