<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Campaign;

class CreateCampaign extends BaseController
{
    
    protected $campaign;

    protected $request;

    protected $message = 'Campaign Created!';

    protected $code = '200';


    public function __construct(Campaign $campaign,Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
        $this->campaign = $campaign;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($project)
    {
        $this->validate($this->request, [
        'campaign_name' => 'required|max:30',
        'campaign_order' => 'int|min:0'
        ]);
        $this->createCampaign($project);
        $campaign = $this->campaign->find($this->campaign->id);
        return response()->json(['message' => $this->message, 'campaign' => $campaign], $this->code);
    }

    private function createCampaign($project)
    {
            $this->addName();
            $this->addOrder();
            $this->save($project);
    }
    private function tenant()
    {
        return auth()->user();
    }

    private function addName()
    {
        $this->campaign->name = $this->request->campaign_name;
    }

    private function addOrder()
    {
        if(isset($this->request->campaign_order)){
        $this->campaign->order = $this->request->campaign_order;
        }
    }


    private function save($project)
    {
        $save = $project->campaigns()->save($this->campaign);
        if(!$save){
        $this->message = 'Campaign Creation Failed!';
        $this->code = 404;
        }
    }


}