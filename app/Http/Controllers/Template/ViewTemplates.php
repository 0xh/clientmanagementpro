<?php

namespace App\Http\Controllers\Template;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Project;

class ViewTemplates extends BaseController
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
    public function __invoke()
    {
        if($this->getAuth()->can('manage-projects',$this->getTenant() || $this->getAuth()->isSuperAdmin()))
        {
            $mytemplatelist = Project::with('campaigns.tasks.subtasks')->where('tenant_id',$this->getAuth()->id)->where('public', true)->get();
            $templates = Project::with('campaigns.tasks.subtasks')->where('tenant_id',$this->getSuperAdmin()->id)->where('public', true)->get();
            return view('template::index',['templates' => $templates,'mytemplatelist' => $mytemplatelist]);
        }else{
        abort(403,'Forbidden To View Templates');
        
        }
    }
}