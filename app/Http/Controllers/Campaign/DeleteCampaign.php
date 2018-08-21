<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteCampaign extends BaseController
{
    
    protected $request;

    protected $message = 'Campaign Deleted!';

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
        $this->deleteCampaign($campaign);
        return response()->json(['message' => $this->message, 'campaign' => $campaign], $this->code);
    }

    private function tenant()
    {
        return auth()->user();
    }

    private function allows($campaign)
    {
        if($campaign->project->byTenant()->id != $this->tenant()->id)
        {
            $this->message = 'UnAuthorized.';
            $this->code = 401;
            return false;
        }
        return true;
        
    }

    private function deleteCampaign($campaign)
    {
        if($this->allows($campaign)){
            $this->delete($campaign);
        }
    }

    private function delete($campaign)
    {
        $deleted = $campaign->delete();
        if(!$deleted){
            $this->message = 'Failed To Delete Campaign';
        }

    }

}