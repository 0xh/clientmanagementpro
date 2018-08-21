<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteTask extends BaseController
{

    protected $message = 'Failed To Delete Task';
    
    protected $code = 400;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task)
    {
        if($this->allowed($task) || $this->createdBy($task)){
            $this->removeAssignedEmployees($task);
            $task->delete();
            $this->message = 'Task Deleted!';
            $this->code = 204;
            return response()->json([], $this->code);
        }
        return response()->json(['message' => $this->message], $this->code);
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

    private function removeAssignedEmployees($task){
        $subtasks = $task->subtasks;
        foreach($subtasks as $subtask){
            $subtask->employees()->sync([]);
        }
    }
}