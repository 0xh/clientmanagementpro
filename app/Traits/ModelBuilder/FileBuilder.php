<?php

namespace App\Traits\ModelBuilder;

use App\Traits\MorphTo\Uploadable;
use App\Traits\Relationship\ByTenant;

trait FileBuilder {
    use Uploadable, ByTenant;
}