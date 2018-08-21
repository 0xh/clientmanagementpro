<?php

namespace Modules\Employee\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class Password extends BaseController
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
    public function __invoke()
    {
        return view('employee::password');
    }
}