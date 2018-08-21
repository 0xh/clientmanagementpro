<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LimitProjectForFreeUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($this->getAuth()->isSuperAdmin()){
            return $next($request);
        }elseif($this->getAuth()->lifetime){
            return $next($request);
        }elseif($this->limitedProject()){
            return response()->json(['message' => 'Upgrade To VIP Plan'], 402);
        }else{
            return $next($request);
        }
    }


    private function getAuth()
    {
        return Auth::user();
    }
    private function limitedProject()
    {
        
        $user =  $this->getAuth();
        $plan = $user->sparkPlan();
        if($plan->name === 'VIP'){
            return false;
        }
        $count = count($user->projects);
        if($count > 2){
            return true;
        }
        return false;
    }
}