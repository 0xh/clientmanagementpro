<?php 

namespace App\Traits\Relationship;

trait CanManageProjects
{
    public function manageProjects()
    {
        return $this->hasMany('App\Project', 'tenant_id', 'id');
    }

}