<?php

namespace Modules\Employee\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class UploadAvatar extends BaseController
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
        if($request->hasFile('avatar')){
    		$avatar = $request->file('avatar');
    		$filename = time() . '.' . $avatar->getClientOriginalExtension();
    		$file = \Image::make($avatar)->resize(300, 300)->save( storage_path('app/public/employee/' . $filename ) );
    		$user = auth()->guard('employee')->user();
    		$user->photo_url = 'storage/employee/'.$filename;
    		$user->save();
    	}
        return redirect()->back();
    }
}