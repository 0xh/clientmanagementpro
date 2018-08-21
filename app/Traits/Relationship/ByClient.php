<?php 

namespace App\Traits\Relationship;

trait ByClient
{
    public function byClient()
    {
        return $this->belongsTo('App\Client', 'client_id', 'id')->select(['id','name','email']);
    }

    public function client()
    {
        return $this->belongsTo('App\Client', 'client_id', 'id');
    }

}