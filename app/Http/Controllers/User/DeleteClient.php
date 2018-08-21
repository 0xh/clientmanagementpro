<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteClient extends BaseController
{
    
    protected $message;

    protected $code = 204;
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
    public function __invoke($client)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            $projects = $client->projects;
            foreach($projects as $project){
                $project->byClient()->dissociate();
            }
            $client->delete();
            return response()->json([], $this->code);
        }
        $this->message = 'UnAuthorized Action';
        $this->code = 401;
        return response()->json(['message' => $this->message],$this->code);
    }
}