<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteSubtask extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task,$subtask)
    {
        if($this->allowed($subtask) || $this->createdBy($subtask))
        {
            $this->detachEmployees($subtask);
            $this->delete($subtask);
            return response()->json(['message' => 'Subtask: '.$subtask->name. ' Deleted!'], 200);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function allowed($subtask)
    {
        
        if($subtask->task->campaign->project->byTenant()->id != $this->getTenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($subtask)
    {
        if($this->getTenant()->projects()->find($subtask->task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function detachEmployees($subtask)
    {
        $subtask->employees()->sync([]);
    }

    private function delete($subtask)
    {
        $deleted = $subtask->delete();
        if(!$deleted)
        {
            return response()->json(['error' => 'Failed To Delete Subtask'], 400);
        }

        return response()->json(['success' => 'Subtask Deleted!'], 200);
    }

    
}