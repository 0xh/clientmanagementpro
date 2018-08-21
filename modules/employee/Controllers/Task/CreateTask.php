<?php

namespace Modules\Employee\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Task;
use App\User;

class CreateTask extends BaseController
{
    protected $task;

    protected $input;

    public function __construct(Task $task, Request $request)
    {
        $this->middleware('auth:employee');
        $this->task = $task;
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($campaign)
    {
        $this->createTask($campaign);
    }

     private function createTask($campaign)
    {

        if($this->authorize($campaign) && $this->canAccessProject($campaign) || $this->createdBy($campaign))
        {
            $this->validateTask($campaign);
            $this->save($campaign);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function authorize($campaign)
    {
        
        if($campaign->project->ByTenant()->id != $this->employee()->tenant_id)
        {
            return false;
        }
        return true;
    }

    private function employee()
    {
       return  auth()->guard('employee')->user();
    }

    private function canAccessProject($campaign)
    {
        foreach($campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $this->employee()->id)
            {
                return true;
            }
        }
        return false;
    }

    private function createdBy($campaign)
    {
        if($this->employee()->projects()->find($campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function validateTask($campaign)
    {
        $this->validate($this->input, [
        'task_name' => 'required|max:30',
        'task_description' => 'max:30',
        'task_link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        ]);
        $this->task->name = $this->input['task_name'];
        $this->task->description = $this->input['task_description'];
        $this->task->link = $this->input['task_link'];
    }

    private function save($campaign)
    {
        $save = $campaign->tasks()->save($this->task);
        if(!$save)
        {
            return response()->json(['error' => 'Failed To Create Task'], 400);
        }
        return response()->json(['success' => 'Task Created!'], 200);
    }

    
}