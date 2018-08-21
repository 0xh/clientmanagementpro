<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\TaskBuilder;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use TaskBuilder, LogsActivity;

    protected $table ='tasks';

    protected $fillable = [
        'name',
        'description',
        'link',
    ];

    protected $casts = [
        'done' => 'boolean',
        'recurring' => 'boolean'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected static $logAttributes = ['name', 'description', 'link', 'recurring', 'interval'];

    protected static $ignoreChangedAttributes = ['updated_at'];

    // protected $appends = ['progress', 'total', 'done', 'percentage'];

    protected static $logOnlyDirty = true;

    public function subtasks()
    {
        return $this->hasMany('App\Subtask','task_id', 'id');
    }

    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $name = null;
        $guards = collect(config('auth.guards'))->keys()->all();
        foreach ($guards as $guard) {
           if(auth()->guard($guard)->check()){
            $name = auth()->guard($guard)->user()->name;
            break;
           }
        }
        if(!$name){
            return "Job has been {$eventName}";
        }
        return "Job {$eventName} by: {$name}";
    }
    // Only Return when you Use toArray()
    // public function getProgressAttribute()
    // {
    //     return self::progress($this->id);
    // }

    // public function getTotalAttribute()
    // {
    //     return self::total($this->id);
    // }

    // public function getDoneAttribute()
    // {
    //     return self::done($this->id);
    // }

    // public function getPercentageAttribute()
    // {
    //     return round(self::get_percentage($this->total_points,$this->done_points));
    // }
}
