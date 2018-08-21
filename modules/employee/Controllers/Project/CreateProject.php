<?php

namespace Modules\Employee\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Project;
use App\Client;
use App\User;

class CreateProject extends BaseController
{
    
    protected $project;

    protected $input;

    protected $client;

    public function __construct(Project $project,Request $request, Client $client)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
        $this->project = $project;
        $this->client = $client;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $this->createProject();
    }

    private function createProject()
    {
        $this->AddName();
        $this->manageProjectsByTenant();
        $this->saveByEmployee();
    }

    private function AddName()
    {
        $this->validate($this->input, [
        'project_name' => 'required|max:30',
        ]);
        $this->project->name = $this->input['project_name'];
    }

    private function tenant()
    {
        return User::find(auth()->guard('employee')->user()->tenant_id);
    }

    private function manageProjectsByTenant()
    {
        $this->tenant()->manageProjects()->save($this->project);
    }

    private function employee()
    {
        return auth()->guard('employee')->user();
    }

    private function saveByEmployee()
    {
        $save = $this->employee()->projects()->save($this->project);
        if(!$save){
        return response()->json(['success' => 'Project Creation Failed.'], 400);
        }
        return response()->json(['success' => 'Project Created!'], 200);
    }
}