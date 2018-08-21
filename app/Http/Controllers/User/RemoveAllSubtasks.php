<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class RemoveAllSubtasks extends BaseController
{   
    protected $message;
    protected $code = 204;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($employee)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            $employee->subtasks()->sync([]);
            return response()->json([], $this->code);
        }
        $this->code = 401;
        $this->message = 'Unauthorized Action';

        return response()->json(['message' => $this->message], $this->code);
    }
}