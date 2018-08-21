<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class DeleteSubtask extends BaseController
{
    protected $subtask;

    protected $input;

    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    public function __invoke($subtask)
    {
        $this->deleteSubtask($subtask);
    }

    private function deleteSubtask($subtask)
    {
        if($this->authorize($tenant,$subtask) && $this->canAccessProject($this->getAuth(),$subtask))
        {
            // remove all data in employee_subtask
            $subtask->sync([]);
            $subtask->delete();
            return response()->json(['success' => 'Subtask Deleted.'], 200);
        }
        return response()->json(['error' => 'UnAuthorized.'], 401);
    }

    private function authorize($subtask)
    {
        if($subtask->task->campaign->project->ByTenant()->id != $this->employee()->tenant_id)
        {
            return false;
        }
        return true;
    }

    // void or unauthorized
    private function canAccessProject($employee,$subtask)
    {
        foreach($subtask->task->campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $employee->id)
            {
                return true;
            }
        }
        return false;
    }

    private function employee()
    {
       return  auth()->guard('employee')->user();
    }

}
