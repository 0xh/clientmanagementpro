<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;

class UnassignedSubtask extends BaseController
{   
    protected $message;
    protected $code = 204;
    protected $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($employee,$projectID, $subtask)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            $employee->subtasks()->detach($subtask->id, ['project_id' => $projectID->id]);
            return response()->json([], $this->code);
        }
        $this->code = 401;
        $this->message = 'Unauthorized Action';

        return response()->json(['message' => $this->message], $this->code);
    }
}