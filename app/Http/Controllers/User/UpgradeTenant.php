<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\User;
use Carbon\Carbon;
use Laravel\Spark\Spark;

class UpgradeTenant extends BaseController
{
    protected $user;
    
    protected $request;

    protected $message = 'Tenant Upgraded To Lifetime Subscription';

    protected $code = '200';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware(['auth']);
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($user)
    {
        if($user->isSuperAdmin()){
            $this->message = 'You Cant Upgrade Super Admin';
            $this->code = 400;
            return response()->json(['message' => $this->message], $this->code);
        }
        if($this->getAuth()->isSuperAdmin()){
            $user->trial_ends_at = null;
            $user->save();
            $user = $user->toArray();
            return response()->json(['message' => $this->message, 'user' => $user], $this->code);
        }
        $this->code = 401;
        $this->message = 'You Are UnAuthorized To Do This Action';
        return response()->json(['message' => $this->message], $this->code);
        
    }


}