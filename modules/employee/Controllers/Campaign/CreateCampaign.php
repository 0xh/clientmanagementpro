<?php

namespace Modules\Employee\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Campaign;

class CreateCampaign extends BaseController
{
    
    protected $campaign;

    protected $input;


    public function __construct(Campaign $campaign,Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
        $this->campaign = $campaign;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($project)
    {
        $this->createCampaign($project);
    }

    private function createCampaign($project)
    {

        if($this->authorize($project) || $this->canAccessProject($project) || $this->createdBy($project))
        {
            $this->addName();
            $this->save($project);
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
       return  auth()->guard('employee')->user();
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

    private function createdBy($project)
    {
        if($this->employee()->projects()->find($project->id))
        {
            return true;
        }
        return false;
    }

    private function addName()
    {
        $this->validate($this->input, [
        'campaign_name' => 'required|max:30',
        ]);
        $this->campaign->name = $this->input['project_name'];
    }

    private function save($project)
    {
        $save = $project->campaigns()->save($project);
        if(!$save){
            return response()->json(['error' => 'Failed To Create Campaign'], 400);
        }
        return response()->json(['success' => 'Campaign Created!'], 200);
    }
}