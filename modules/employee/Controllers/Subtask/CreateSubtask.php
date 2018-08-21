<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Subtask;
use App\User;

class CreateSubtask extends BaseController
{
    protected $subtask;

    protected $input;

    public function __construct(Subtask $subtask, Request $request)
    {
        $this->middleware('auth:employee');
        $this->subtask = $subtask;
        $this->input = $request->all();
    }

    public function __invoke($task)
    {
        $this->createSubtask($task);
    }

    private function createSubtask($task)
    {
        if($this->authorize($task) && $this->canAccessProject($task) || $this->createdBy($task))
        {
            $this->validateSubtask($task);
            $this->create($task);
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

    private function tenant()
    {
       return  User::find($this->employee()->tenant_id);
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

    private function validateSubtask($task)
    {
        $priority_array = [1,2,3,4,5];
        $this->validate($this->input, [
        'subtask_name' => 'required|max:30',
        'subtask_link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'subtask_points' => 'integer|min:0',
        'subtask_priority' => 'in:' . implode(',', $priority_array),
        'subtask_due_date' => 'date_format:d/m/Y|after:tomorrow',
        ]);
        $this->subtask->name = $this->input->subtask_name;
        $this->subtask->link = $this->input->subtask_link;
        $this->subtask->points = $this->input->subtask_points;
        $this->subtask->priority = $this->input->subtask_priority;
        $this->subtask->due_date = $this->input->subtask_due_date;
    }

    private function create($task)
    {
        $save = $task->subtasks()->save($this->subtask);
        if(!$save)
        {
            return response()->json(['error' => 'Failed To Create Subtask'], 400);
        }
        return response()->json(['success' => 'Subtask Created!'], 200);
    }
    
}
