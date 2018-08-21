<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;
use App\Task;

class ShowEmployee extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $employees = Employee::where('tenant_id',$this->getTenant()->id)->get();
        $workers = $employees->toArray();
        $count = 0;
        foreach($employees as $employee){
            $tasks = [];
            foreach($employee->subtasks as $subtask){
                $tasks[$subtask->task_id] = $subtask->task_id;
            }
            
            $tasks = array_flatten($tasks);
            $tasks = Task::findMany($tasks)->toArray();
            $workers[$count]['tasks'] =  $tasks;
            $count++;
        }
        return view('tenant::employee',['employees' => $workers]);
    }
}