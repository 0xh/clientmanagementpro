<?php

namespace Modules\Employee\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class UpdateProfile extends BaseController
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
    public function __invoke(Request $request)
    {
        $employee = auth()->guard('employee')->user();
        $employee->name = $request->input('name');
        $employee->email = $request->input('email');
        $employee->save();
        return redirect()->back();
    }
}