<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Relationship\ByTenant;
use App\Traits\Relationship\ByClient;
use App\Traits\Relationship\AssignedEmployees;
use App\Traits\MorphTo\Projectable;
use App\Traits\Relationship\HasFiles;

trait ProjectBuilder {
    use ByTenant, ByClient, AssignedEmployees, Projectable, HasFiles;
}