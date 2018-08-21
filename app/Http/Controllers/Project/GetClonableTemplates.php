<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Project;

class GetClonableTemplates extends BaseController
{
    protected $message= 'Forbidden To View Templates.';
    protected $code = 403;

    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->request = $request;
    }
    // Only Load The SuperAdmin Project That is Set to Public
    public function __invoke()
    {
        if($this->getAuth()->can('manage-projects',$this->getTenant()) || $this->getAuth()->isSuperAdmin())
        {
            $templates = Project::where('tenant_id',$this->getSuperAdmin()->id)->where('public', true)->get();
            $this->message = ($templates->count() > 0) ? 'Templates Loaded.' : 'No Templates Available Yet.';
            $this->code = 200;
            return response()->json(['message' => $this->message, 'templates' =>$templates],$this->code);
        }else{
            return response()->json(['message' => $this->message],$this->code);
        }
    }
}