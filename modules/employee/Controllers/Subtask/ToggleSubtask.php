<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;
use Spatie\Activitylog\Models\Activity;

class ToggleSubtask extends BaseController
{

    protected $message;

    protected $log;

    protected $code = 401;

    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function __invoke($task,$subtask)
    {
        $old_task = $task;

        if($this->allowed($task) || $this->createdBy($task))
        {
            if($subtask->employees->contains('email',$this->getAuth()->email)){
                $subtask->done = !$subtask->done;
                $subtask->save();
                $subtask->employees;
                $this->code = 200;
                $this->message = $subtask->done ? 'Subtask Mark As Done' : 'Subtask Undone';
                if($old_task->done != $task->fresh()->done){
                    $this->log = Activity::where('subject_type', 'App\Task')->where('subject_id', $task->id)->latest()->first();
                }
                return response()->json(['subtask' => $subtask,'message' => $this->message,'log' => $this->log], $this->code);
            }
            return response()->json(['error' => 'You Are Not Assigned To This Task!'], 401);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function allowed($task)
    {
        
        if($task->campaign->project->byTenant()->id != $this->getTenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($task)
    {
        if($this->getTenant()->projects()->find($task->campaign->project->id))
        {
            return true;
        }
        return false;
    }
}
