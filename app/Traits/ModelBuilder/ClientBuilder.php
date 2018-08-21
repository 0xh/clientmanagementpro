<?php

namespace App\Traits\ModelBuilder;

use App\Traits\Relationship\ByTenant;
use App\Traits\Mutators\UsersMutator;
use App\Traits\Methods\UsersMethod;
use App\Traits\MorphTo\Clientable;
use App\Traits\Relationship\HasComments;
use App\Traits\Relationship\CanManageFiles;
use Illuminate\Notifications\Notifiable;

trait ClientBuilder {
    use ByTenant, UsersMutator, UsersMethod, 
    Clientable, HasComments, CanManageFiles, Notifiable;
}