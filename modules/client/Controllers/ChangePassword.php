<?php

namespace Modules\Client\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class ChangePassword extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:client');
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = auth()->guard('client')->user();
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            $failed = 'The given password does not match our records.';
            return view('client::password',['failed' => $failed]);
        }

        $user->forceFill([
            'password' => $request->password
        ])->save();
        $success = 'You Have Successfully Changed A New Password!';
        return view('client::password',['success' => $success]);
    }
}