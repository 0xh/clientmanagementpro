<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class ReOrderCampaign extends BaseController
{
    
    protected $request;

    protected $message = 'Campaign Re-Order!';

    protected $code = '200';

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($campaign)
    {
        
        $this->switchOrder($campaign);
        
        return response()->json(['message' => $this->message, 'campaign' => $campaign], $this->code);
        
        
    }

    private function allows($campaign)
    {
        if($campaign->project->byTenant()->id != $this->tenant()->id)
        {
            $this->message = 'UnAuthorized';
            $this->code = 401;
            return false;
        }
        return true;
    }


    private function addOrder($campaign)
    {
        if(isset($this->request->campaign_order)){
        $campaign->order = abs($this->request->campaign_order);
        }
    }
    private function tenant()
    {
        return auth()->user();
    }

    private function switchOrder($campaign)
    {
        if($this->allows($campaign)){
            $this->addOrder($campaign);
            $this->save($campaign);
        }
    }

    private function save($campaign)
    {
        $save = $campaign->save();
        if(!$save){
        $this->message = 'Campaign Re Order Failed!';
        $this->code = 404;
        }
    }
}