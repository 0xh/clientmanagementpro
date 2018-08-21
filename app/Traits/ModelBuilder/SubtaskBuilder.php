<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Relationship\SubtaskHasEmployees;
use App\Traits\Relationship\SubtaskIsOwnByProject;

trait SubtaskBuilder {
    use SubtaskHasEmployees , SubtaskIsOwnByProject;
}