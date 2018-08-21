<?php 

namespace App\Traits\Relationship;

use BrianFaust\Commentable\Comment;

trait HasComments
{
    // This Trait Needs to Be Added to User, Employee and Clients
    // Since a User, Employee, Client Can Comment
    public function comments()
    {
        return $this->morphMany(Comment::class, 'creator');
    }
}