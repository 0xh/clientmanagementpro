<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;

class ShowTenant extends BaseController
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
        if($this->getSuperAdmin()->id === $this->getTenant()->id){
            $users = User::all()->toArray();
            return view('tenant::manage',['users' => $users]);
        }
        else{
            return redirect()->route('dashboard');

        }
        
    }
}