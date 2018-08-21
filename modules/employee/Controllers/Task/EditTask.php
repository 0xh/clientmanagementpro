<?php

namespace Modules\Employee\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class EditTask extends BaseController
{

    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task)
    {
        $this->editTask($task);
    }

    private function editTask($task)
    {
       if($this->authorize($task) && $this->canAccessProject($task) || $this->createdBy($task))
        {
            $this->validateTask($task);
            $this->update($task);
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

    private function validateTask($task)
    {
        $this->validate($this->input, [
        'task_name' => 'required|max:30',
        'task_description' => 'max:30',
        'task_link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'task_done' => 'boolean'
        ]);
        $task->name = $this->input['task_name'];
        $task->description = $this->input['task_description'];
        $task->link = $this->input['task_link'];
        $task->done = $this->input['task_done'];
    }

    private function update($task)
    {
        $save = $task->save();
        if(!$save)
        {
            return response()->json(['error' => 'Failed To Edit Task'], 400);
        }
        return response()->json(['success' => 'Task Edited!'], 200);
    }

    
}