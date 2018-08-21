<?php 

namespace App\Traits\MorphTo;

trait Employable
{
    public function employable()
    {
        return $this->morphTo();
    }
}