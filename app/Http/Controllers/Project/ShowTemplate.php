<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Project;
use App\Campaign;

class ShowTemplate extends BaseController
{
    protected $message= 'You Dont Have Permission For This Action';
    protected $code = 403;

    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->request = $request;
    }

    public function __invoke($project)
    {
        $tenant = $this->getTenant();
        if($this->getAuth()->can('manage-projects',$tenant) || $this->getAuth()->isSuperAdmin())
        {
            $campaigns = Campaign::where('project_id', $project->id)->with('tasks')->orderBy('order', 'asc')->get();
            $workers = $project->assignedEmployees;
            return view('project::view',['project' => $project, 'campaigns' => $campaigns, 'workers' => $workers]);
        }else{
            abort(403,'Forbidden To View Templates');
        }
    }
}