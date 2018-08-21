<?php

namespace Modules\Employee\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Client;
use App\User;

class EditProject extends BaseController
{
    
    protected $input;

    protected $client;

    public function __construct(Request $request, Client $client)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
        $this->client = $client;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($project)
    {
        $this->editProject($project);
    }

    private function editProject($project)
    {
        if($this->authorize($project) && $this->canAccessProject($project) || $this->createdBy($project))
        {
            $this->editName($project);
            $this->AddClientIfAny($project);
            $this->update($project);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }



    private function authorize($project)
    {
        
        if($project->ByTenant()->id != $this->employee()->tenant_id)
        {
            return false;
        }
        return true;
    }

    private function employee()
    {
        return auth()->guard('employee')->user();
    }

    private function canAccessProject($project)
    {
        foreach($project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $this->employee()->id)
            {
                return true;
            }
        }
        return false;
    }

    private function createdBy()
    {
        $project = $this->employee()->projects()->find($this->project->id);
        if($project)
        {
            return $true;
        }
    }

    private function editName($project)
    {
        $this->validate($this->input, [
        'project_name' => 'required|max:30',
        ]);
        $project->name = $this->input['project_name'];
    }

    private function AddClientIfAny($project)
    {
        if(isset($this->input['client_id'])){
            $tenant_clients = $this->tenant()->clients->pluck('id')->toArray();
            $client_id = $this->input['client_id'];
            if(in_array($client_id,$tenant_clients))
            {
            $project->client_id = $client_id;
            }
        }
    }

    private function tenant()
    {
        return User::find(auth()->guard('employee')->user()->tenant_id);
    }

    private function update($project)
    {
        $save = $project->save($project);
        if(!$save){
        return response()->json(['success' => 'Editing Project Failed!'], 400);
        }
        return response()->json(['success' => 'Project Editted!'], 200);
    }
    
}