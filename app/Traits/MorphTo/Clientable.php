<?php 

namespace App\Traits\MorphTo;

trait Clientable
{
    public function clientable()
    {
        return $this->morphTo();
    }
}