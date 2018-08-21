<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Client;
use App\Project;

class ShowClient extends BaseController
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
        $tenant = $this->getTenant()->id;
        $projectlist = Project::where('tenant_id',$tenant)->where('client_id', null)->get();
        $clientlist = Client::with('projects')->where('tenant_id',$tenant)->get();
        return view('tenant::client',['clientlist' => $clientlist,'projectlist' => $projectlist]);
    }
}