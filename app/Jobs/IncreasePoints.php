<?php

namespace App\Jobs;

use Log;
use Exception;
use App\Subtask;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class IncreasePoints implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $subtask;

    /**
     * Create a new job instance.
     *
     * @param  Podcast  $podcast
     * @return void
     */
    public function __construct(Subtask $subtask)
    {
        $this->subtask = $subtask;
    }

    
    public function handle()
    {
        $points = $this->subtask->points;
        $done = $this->subtask->done;
        $task = $this->subtask->task;
        $campaign = $task->campaign;
        
        if (!$task) {
            throw new Exception('Associate a Task at this Subtask: '.$this->subtask->id.'. Decreasing Task Points Failed!');
        }
        elseif (!$campaign) {
            throw new Exception('Associate a Campaign at this Subtask:'.$this->subtask->id. '. Decreasing Campaign Points Failed!');
        }
        
        $task->total_points = $task->total_points + $points;
        $campaign->total_points = $campaign->total_points + $points;
        if($done){
        $task->done_points =  $task->done_points  + $points;
        $campaign->done_points =  $campaign->done_points  + $points;
        }
        $task->save();
        $campaign->save();
        
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $e)
    {
        Log::error($e->getMessage());
    }
}