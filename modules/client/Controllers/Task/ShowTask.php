<?php

namespace Modules\Client\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Spatie\Activitylog\Models\Activity;

class ShowTask extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task)
    {
        $task = $task;
        $project = $task->campaign()->first()->project()->first();
        $campaign = $task->campaign()->first();
        $client = $task->campaign()->first()->project()->first()->byClient()->first();
        $workers = $task->campaign()->first()->project()->first()->assignedEmployees()->get();
        $activities = Activity::where('subject_type', 'App\Task')->where('subject_id', $task->id)->get();
        return view('task::view',['task' => $task, 'project' => $project, 'workers' => $workers, 'client' => $client, 'campaign' => $campaign, 'activities' => $activities]);
    }
}