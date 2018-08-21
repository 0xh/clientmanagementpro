<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\SubtaskBuilder;

class Subtask extends Model
{
    use SubtaskBuilder;

    protected $table ='subtasks';

    protected $fillable = [
        'name',
        'points',
        'priority',
        'link',
        'due_date',
    ];

    protected $casts = [
        'done' => 'boolean',
        'priority' => 'integer'
    ];

    protected $dates = ['created_at', 'updated_at', 'due_date'];

    public function task()
    {
        return $this->belongsTo('App\Task', 'task_id', 'id');
    }
}
