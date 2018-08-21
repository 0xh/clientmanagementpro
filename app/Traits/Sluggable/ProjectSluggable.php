<?php

namespace App\Traits\Sluggable;

trait ProjectSluggable
{
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function forbiddenSlug()
    {
        return array();
    }
}