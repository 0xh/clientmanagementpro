<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EmployeeUnassignSubtask extends BaseController
{
    protected $message = 'Unauthorized Action';
    protected $code = 401;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task,$employee,$subtask)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            $project = $task->campaign->project;
            $employee->subtasks()->detach($subtask->id, ['project_id' => $project->id]);
            $subtask = $subtask->fresh();
            $subtask->employees;
            $this->code = 200;
            return response()->json(['message' => 'Task Unassigned','subtask' => $subtask], $this->code);
        }

        return response()->json(['message' => $this->message], $this->code);
    }
}