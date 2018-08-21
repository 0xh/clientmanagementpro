<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Spatie\Activitylog\Models\Activity;
use App\Employee;

class ShowTask extends BaseController
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
    public function __invoke($task)
    {
        $task = $task;
        $project = $task->campaign()->first()->project()->first();
        $campaign = $task->campaign()->first();
        $client = $task->campaign()->first()->project()->first()->byClient()->first();
        $workers = $this->getWorkers($task);
        $activities = Activity::where('subject_type', 'App\Task')->where('subject_id', $task->id)->get();
        return view('task::view',['task' => $task, 'project' => $project, 'workers' => $workers, 'client' => $client, 'campaign' => $campaign, 'activities' => $activities]);
    }

    private function getWorkers($task){
        $workers = $task->campaign()->first()->project()->first()->assignedEmployees()->get();
        $teammates = [];

        if(count($workers)){
            for ($i=0; $i < count($workers); $i++) { 
                $e = Employee::with('assignedprojects.subtasks')->where('id',$workers[$i]['id'])->first();
                array_push($teammates, $e);
            }
        }
        return $teammates;
    }
}