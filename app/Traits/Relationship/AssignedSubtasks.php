<?php 

namespace App\Traits\Relationship;

trait AssignedSubtasks
{
    // This Trait Needs to Be Added to Employee
    // So We Can Easily Get Array of Projects
    // That An Employee Can Access
    public function assignedSubtasks()
    {
        return $this->belongsToMany('App\Subtask', 'employee_subtask');
    }
}