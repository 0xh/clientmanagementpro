<?php

namespace App\Observers;

use App\Subtask;
use App\Jobs\DecreasePoints;
use App\Jobs\IncreasePoints;
use Log;

class SubtaskObserver
{
    /**
     * Listen to the Subtask created event.
     *
     * @param  Subtask  $subtask
     * @return void
     */
    public function created(Subtask $subtask)
    {
        $job = (new IncreasePoints($subtask))->onQueue('add_points');
        dispatch($job);
    }


    
    // we need the deleting...
    public function deleting(Subtask $subtask)
    {
        $job = (new DecreasePoints($subtask))->onQueue('decrease_points');
        dispatch($job);
    }

    public  function updating(Subtask $subtask)
    {
           $this->processDonePoints($subtask);
           $this->processTotalPoints($subtask);
           $this->updateTaskStatus($subtask);
    }
    private function updateTaskStatus($subtask){
        if($subtask->task->total_points === $subtask->task->done_points && $subtask->task->total_points){
            $task = $subtask->task;
            $task->done = true;
            $task->save();
        }else{
         $task = $subtask->task;
         $task->done = false;
         $task->save();
        }
    }
    private function processTotalPoints($subtask)
    {


            $record = $this->getRecord($subtask);
            
            
            if($record['points']['old'] < $record['points']['new']){
                    $diff = abs($record['points']['old'] - $record['points']['new']);
                    $subtask->task->increment('total_points',$diff);
                    $subtask->task->campaign->increment('total_points',$diff);
            }else{
                    $diff = abs($record['points']['old'] - $record['points']['new']);
                    $subtask->task->decrement('total_points',$diff);
                    $subtask->task->campaign->decrement('total_points',$diff);
            }
        

    }

    private function getChanges($subtask)
    {
        return $changes = $subtask->isDirty() ? $subtask->getDirty() : array();
    }

    private function getRecord($subtask)
    {
        $new = $this->getChanges($subtask);

        $changes['points']['old'] = $subtask->getOriginal('points');
        $changes['points']['new'] = isset($new['points']) ? $new['points'] : $subtask->getOriginal('points');

        $changes['done']['old']  = $subtask->getOriginal('done');
        $changes['done']['new']  = isset($new['done']) ? $new['done'] : $subtask->getOriginal('done');

        return $changes;
    }

    private function processDonePoints($subtask)
    {

            $record = $this->getRecord($subtask);
            // false to true
            // working
            if(!$record['done']['old'] && $record['done']['new'])
            {
                $diff = $record['points']['new'];
                $subtask->task->increment('done_points',$diff);
                $subtask->task->campaign->increment('done_points',$diff);
            }
            // true to false
            if($record['done']['old'] && !$record['done']['new'])
            {
                $diff = $record['points']['old'];
                $subtask->task->decrement('done_points',$diff);
                $subtask->task->campaign->decrement('done_points',$diff);
            }
            // both are true
            if($record['done']['old'] && $record['done']['new'])
            {
                // 0<5 increased
                if($record['points']['old']< $record['points']['new'])
                {
                    $diff = abs($record['points']['old'] - $record['points']['new']);
                    $subtask->task->increment('done_points',$diff);
                    $subtask->task->campaign->increment('done_points',$diff);
                }
                else{
                    $diff = abs($record['points']['old'] - $record['points']['new']);
                    $subtask->task->decrement('done_points',$diff);
                    $subtask->task->campaign->decrement('done_points',$diff);
                }
            }
    }
        

}