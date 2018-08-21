<?php 

namespace App\Traits\Relationship;

trait HasFiles
{
    // This Trait Needs to Be Added to User and Employee
    // Since a User and Employee Can Upload File
    public function files()
    {
        return $this->HasMany('App\File');
    }
}