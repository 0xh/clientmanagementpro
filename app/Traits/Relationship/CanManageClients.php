<?php 

namespace App\Traits\Relationship;

trait CanManageClients
{
    public function managedClients()
    {
        return $this->hasMany('App\Client', 'tenant_id', 'id')->select(['id','name','email']);
    }
}