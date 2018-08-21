<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Project;


class ToggleClonable extends BaseController
{
    protected $message= 'Forbidden To Toggle Clonable Action.';
    protected $code = 403;

    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->request = $request;
    }

    public function __invoke($project)
    {
        if($this->getAuth()->can('toggle-clonable',$project) || $this->getAuth()->isSuperAdmin())
        {
            $project->public = !$project->public;
            $project->save();
            $this->message = $project->public ? 'Added To Clonable Templates' : 'Remove From Clonable Templates';
            $this->code = 200;
            return response()->json(['message' => $this->message, 'project' => $project],$this->code);
        }else{
            return response()->json(['message' => $this->message],$this->code);
        }
    }
}