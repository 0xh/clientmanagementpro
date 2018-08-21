<?php

namespace Modules\Employee\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;

class ViewSubtask extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($subtask)
    {
        $project = $subtask->task->campaign->project;
        $subtask->employees; // eager load all employees assign to subtask
        $task = $subtask->task()->first();
        $client = $task->campaign()->first()->project()->first()->byClient()->first();
        $workers = Employee::where('tenant_id', $this->getTenant()->id)->get();
        return view('subtask::view-subtask',['subtask' => $subtask, 'task' => $task, 'project' => $project, 'workers' => $workers, 'client' => $client,]);
    }
}