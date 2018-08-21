<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Campaign;

class ShowProject extends BaseController
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
    public function __invoke($project)
    {
        $campaigns = Campaign::where('project_id', $project->id)->with('tasks')->orderBy('order', 'asc')->get();
        $workers = $project->assignedEmployees;
        return view('project::view',['project' => $project, 'campaigns' => $campaigns, 'workers' => $workers]);
    }
}