<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;

class DeleteEmployee extends BaseController
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
    public function __invoke($employee)
    {
        if($this->getAuth()->id === $this->getTenant()->id){
            $employee->subtasks()->sync([]);
            $employee->delete();
            

            return response()->json([], $this->code);
        }
        $this->message = 'Failed To Delete Teammate';
        $this->code = 400;
        return response()->json(['message' => $this->message],$this->code);
    }
}