<?php 

namespace App\Traits\MorphTo;

trait Projectable
{
    public function projectable()
    {
        return $this->morphTo();
    }
}