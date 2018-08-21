<?php

namespace Modules\Client\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;

class ShowSubtask extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task)
    {
        if($this->allowed($task) || $this->createdBy($task))
        {
            $subtasks = Subtask::with('employees')->where('task_id',$task->id)->get();
            return response()->json(['subtasks' => $subtasks], 200);
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