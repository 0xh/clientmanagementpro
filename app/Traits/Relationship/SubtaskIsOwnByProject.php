<?php 

namespace App\Traits\Relationship;

trait SubtaskIsOwnByProject
{
    public function project()
    {
        return $this->belongsToMany('App\Project', 'employee_subtask')->withPivot('employee_id');
    }
}