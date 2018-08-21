<?php 

namespace App\Traits\Relationship;

trait CanManageFiles
{
    // This Trait Needs to Be Added to User and Employee
    // Since a User and Employee Can Upload File
    public function canUploadFiles()
    {
        return $this->morphMany('App\File', 'uploadable');
    }
}