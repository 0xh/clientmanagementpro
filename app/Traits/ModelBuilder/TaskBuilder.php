<?php

namespace App\Traits\ModelBuilder;

use BrianFaust\Commentable\HasComments;
use App\Traits\Methods\LoggersMethod;
use App\Traits\Methods\NormalizerMethod;
use App\Traits\Methods\TaskProgressMethod;

trait TaskBuilder {
    use HasComments, LoggersMethod, NormalizerMethod, TaskProgressMethod;
}