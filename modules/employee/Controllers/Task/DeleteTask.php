<?php

namespace Modules\Employee\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class DeleteTask extends BaseController
{


    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function __invoke($task)
    {
        $this->deleteTask($task);
    }

    private function deleteTask($task)
    {
       if($this->authorize($task) && $this->canAccessProject($task) || $this->createdBy($task))
        {
            $this->delete($task);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function authorize($task)
    {
        
        if($task->campaign->project->ByTenant()->id != $this->employee()->tenant_id)
        {
            return false;
        }
        return true;
    }

    private function employee()
    {
       return  auth()->guard('employee')->user();
    }

    private function canAccessProject($task)
    {
        foreach($task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $this->employee()->id)
            {
                return true;
            }
        }
        return false;
    }

    private function createdBy($task)
    {
        if($this->employee()->projects()->find($task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function delete($task)
    {
        $deleted = $task->delete();
        if(!$deleted)
        {
            return response()->json(['error' => 'Failed To Delete Task'], 400);
        }
        return response()->json(['success' => 'Task Deleted!'], 200);
    }

    
}