<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;

class EmployeeUnassignAllSubtask extends BaseController
{
    protected $message = 'Unauthorized Action';
    protected $code = 401;
    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task,$employee)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            $project = $task->campaign->project;
            $subtasks = $this->request->subtasks;
            foreach ($subtasks as $subtask) {
            $employee->subtasks()->detach($subtask['id'], ['project_id' => $project->id]);
            }
            $subtasks = Subtask::with('employees')->where('task_id',$task->id)->get();
            $this->code = 200;
            return response()->json(['message' => 'All Tasks Was Unassigned','subtasks' => $subtasks], 200);
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

}