<?php

namespace Modules\Employee\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class EditCampaign extends BaseController
{
    
    protected $input;


    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
        $this->input = $request->all();
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($campaign)
    {
        $this->editCampaign($campaign);
        return response()->json(['success' => 'Campaign Edited.'], 200);
    }

    private function editCampaign($campaign)
    {

        if($this->authorize($campaign) && $this->canAccessProject($campaign) || $this->createdBy($campaign))
        {
            $this->editName($campaign);
            $this->update($campaign);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function authorize($campaign)
    {
        if($campaign->project->ByTenant()->id != $this->tenant()->id)
        {
            return false;
        }
        return true;
        
    }

    private function canAccessProject($campaign)
    {
        foreach($campaign->project->assignedEmployees as $assignedEmployee)
        {

            if($assignedEmployee->id === $this->employee()->id)
            {
                return true;
            }
        }
        return false;
    }

    private function createdBy($campaign)
    {
        if($this->employee()->projects()->find($campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function employee()
    {
       return  auth()->guard('employee')->user();
    }
    private function tenant()
    {
        return User::find($this->employee()->tenant_id);
    }

    private function editName($campaign)
    {
        $this->validate($this->input, [
        'campaign_name' => 'required|max:30',
        ]);
        $campaign->name = $this->input['project_name'];
    }

    private function update($campaign)
    {
        $save = $campaign->save();
        if(!$save){
            return response()->json(['error' => 'Failed To Edit Campaign'], 400);
        }
        return response()->json(['success' => 'Campaign Editted!'], 200);
    }




}