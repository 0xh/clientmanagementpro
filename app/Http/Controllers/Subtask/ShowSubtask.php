<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;
use App\Employee;

class ShowSubtask extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:web');
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
            $workers = $this->getWorkers($task);
            return response()->json(['subtasks' => $subtasks, 'workers' => $workers], 200);
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

    private function getWorkers($task){
        $workers = $task->campaign()->first()->project()->first()->assignedEmployees()->get();
        $teammates = [];

        if(count($workers)){
            for ($i=0; $i < count($workers); $i++) { 
                $e = Employee::with('assignedprojects.subtasks')->where('id',$workers[$i]['id'])->first();
                array_push($teammates, $e);
            }
        }
        return $teammates;
    }
    
}