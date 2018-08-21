<?php

namespace Modules\Employee\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteProject extends BaseController
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
    public function __invoke($project)
    {
        $this->deleteProject($project);
    }

    private function deleteProject($project)
    {
        if($this->createdBy($project))
        {
            $project->delete();
            return response()->json(['success' => 'Project Deleted!'], 200);
        }
        return response()->json(['error' => 'Actions Not Permitted!'], 401);
    }

    private function employee()
    {
        return auth()->guard('employee')->user();
    }

    private function createdBy()
    {
        $project = $this->employee()->projects()->find($this->project->id);
        if($project)
        {
            return $true;
        }
    }

}