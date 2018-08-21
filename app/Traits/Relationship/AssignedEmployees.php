<?php 

namespace App\Traits\Relationship;

trait AssignedEmployees
{
    // This Trait Needs to Be Added to Project
    // So We Can Easily Get Array of Employees
    // That Can Access a Certain Project
    public function assignedEmployees()
    {
        return $this->belongsToMany('App\Employee', 'employee_subtask')->distinct();
    }
}