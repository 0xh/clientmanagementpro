<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EmployeeTask extends BaseController
{

    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task,$employee)
    {
        $subtasks = $employee->subtasks()->where('task_id',$task->id)->get();
        return response()->json(['subtasks' => $subtasks], 200);
    }

}