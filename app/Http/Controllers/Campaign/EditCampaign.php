<?php

namespace App\Http\Controllers\Campaign;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Campaign;

class EditCampaign extends BaseController
{
    
    protected $request;

    protected $message = 'Campaign Edited!';

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
        $validator = $this->sanitize();
        if($validator->fails())
        {
            $this->code = 422;
            $this->message = 'Failed To Edit '. $campaign->name;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        $this->editCampaign($campaign);
        $campaign = Campaign::with('tasks')->where('id',$campaign->id)->first();
        
        return response()->json(['message' => $this->message, 'campaign' => $campaign], $this->code);
        
        
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'campaign_name' => 'required|max:30',
        'campaign_order' => 'int|min:0'
        ];
    }
    private function messages(){
        return [
            'campaign_name.required' => 'Type A Name For this Campaign',
            'campaign_name.max' => 'Campaign Name Too Long',
            'campaign_order.int' => 'Campaign Order Must Be Integer',
            'campaign_order.min' => 'Campaign Order Must Not Be Lesser Than Zero',
        ];
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

    private function addName($campaign)
    {
        $campaign->name = $this->request->campaign_name;
    }

    private function addOrder($campaign)
    {
        if(isset($this->request->campaign_order)){
        $campaign->order = $this->request->campaign_order;
        }
    }
    private function tenant()
    {
        return auth()->user();
    }

    private function editCampaign($campaign)
    {
        if($this->allows($campaign)){
            $this->addName($campaign);
            $this->addOrder($campaign);
            $this->save($campaign);
        }
    }

    private function save($campaign)
    {
        $save = $campaign->save();
        if(!$save){
        $this->message = 'Campaign Creation Failed!';
        $this->code = 404;
        }
    }
}