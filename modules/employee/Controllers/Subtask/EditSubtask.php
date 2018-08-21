<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class EditSubtask extends BaseController
{
    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    public function __invoke($subtask)
    {
        $this->editSubtask($subtask);
    }

    private function editSubtask($subtask)
    {
       if($this->authorize($subtask) && $this->canAccessProject($subtask) || $this->createdBy($subtask))
        {
            $this->validateTask($subtask);
            $this->update($subtask);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

   private function authorize($subtask)
    {
        
        if($subtask->task->campaign->project->ByTenant()->id != $this->employee()->tenant_id)
        {
            return false;
        }
        return true;
    }

    private function employee()
    {
       return  auth()->guard('employee')->user();
    }

    private function canAccessProject($subtask)
    {
        foreach($subtask->task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $this->employee()->id)
            {
                return true;
            }
        }
        return false;
    }

    private function createdBy($subtask)
    {
        if($this->employee()->projects()->find($subtask->task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function validateTask($subtask)
    {
        $this->validate($this->input, [
        'subtask_name' => 'required|max:30',
        'subtask_link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'subtask_points' => 'integer|min:0',
        'subtask_priority' => 'in:' . implode(',', $priority_array),
        'subtask_due_date' => 'date_format:d/m/Y|after:tomorrow',
        'subtask_done' => 'boolean',
        ]);
        $subtask->name = $this->input->subtask_name;
        $subtask->points = $this->input->subtask_link;
        $subtask->link = $this->input->subtask_points;
        $subtask->priority = $this->input->subtask_priority;
        $subtask->due_date = $this->input->subtask_due_date;
        $subtask->done = $this->input->subtask_done;
        
    }

    private function update($subtask)
    {
        $save = $subtask->save();
        if(!$save)
        {
            return response()->json(['error' => 'Failed To Edit Subtask'], 400);
        }
        return response()->json(['success' => 'Subtask Edited!'], 200);
    }
}
