<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteProject extends BaseController
{

    protected $request;

    protected $message = 'Project Deleted!';

    protected $code = '200';

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }
    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($project)
    {
        $this->deleteProject($project);
        return response()->json(['message' => $this->message, 'project' => $project], $this->code);
    }

    private function tenant()
    {
        return auth()->user();
    }

    private function allows($project)
    {
        if($project->byTenant()->id != $this->tenant()->id)
        {
            $this->message = 'UnAuthorized.';
            $this->code = 401;
            return false;
        }
        return true;
    }
    private function deleteProject($project)
    {
        if($this->allows($project)){
            $this->delete($project);
        }
    }

    private function delete($project)
    {
        $deleted = $project->delete();
        if(!$deleted){
            $this->message = 'Failed To Delete Project';
        }

    }
       

}
