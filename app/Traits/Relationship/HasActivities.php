<?php 

namespace App\Traits\Relationship;

use Spatie\Activitylog\Traits\CausesActivity;

trait HasActivities
{
    // Usage:
    // Trait which can be added to any model that you use as a causer
    // User::find($userId)->activity;
    // Task::first(1)->activity;
    use CausesActivity;
}