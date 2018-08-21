<?php 

namespace App\Traits\Relationship;

trait EmployeeHasSubtasks
{
    public function subtasks()
    {
        return $this->belongsToMany('App\Subtask', 'employee_subtask')->withPivot('project_id');
    }
}