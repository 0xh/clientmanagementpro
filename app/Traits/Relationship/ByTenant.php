<?php 

namespace App\Traits\Relationship;

trait ByTenant
{
    public function byTenant()
    {
        return $this->belongsTo('App\User', 'tenant_id', 'id')->select(['id','name','email', 'username'])->first();
    }

}