<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelBuilder\CampaignBuilder;

class Campaign extends Model
{
    use CampaignBuilder;
    protected $table ='campaigns';

    protected $fillable = [
        'name',
        'order'
    ];

    protected $casts = [
        'done' => 'boolean'
    ];

    // protected $appends = ['progress','total', 'done', 'percentage'];

    protected $dates = ['created_at', 'updated_at'];

    public function tasks()
    {
        return $this->hasMany('App\Task', 'campaign_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id');
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
