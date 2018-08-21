<?php 

namespace App\Traits\Relationship;

trait SubtaskHasEmployees
{
    public function employees()
    {
        return $this->belongsToMany('App\Employee', 'employee_subtask')->withPivot('project_id');
    }
}