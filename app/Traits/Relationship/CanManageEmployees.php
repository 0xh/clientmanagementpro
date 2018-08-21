<?php 

namespace App\Traits\Relationship;

trait CanManageEmployees
{
    public function managedEmployees()
    {
        return $this->hasMany('App\Employee', 'tenant_id', 'id')->select(['id','name','email']);
    }

}