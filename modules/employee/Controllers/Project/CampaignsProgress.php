<?php

namespace Modules\Employee\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class CampaignsProgress extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */

    public function __invoke($project)
    {
        $campaigns = $project->campaigns()->get()->toArray();
        return response()->json($campaigns);
    }
}