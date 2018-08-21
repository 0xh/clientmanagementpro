<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class UpdateRatings extends BaseController
{

    protected $request;

    protected $message = 'Ratings Updated!';

    protected $code = 200;

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
    public function __invoke($subtask)
    {
        $validator = $this->sanitize();
        if($validator->fails())
        {
            $this->message = 'Updating Ratings Failed!';
            $this->code = 422;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->allowed($subtask) || $this->createdBy($subtask))
        {
            $subtask->priority = $this->request->subtask_priority;
            
            $save = $subtask->save();
            
            if(!$save){
            $this->message = 'Updating Ratings Failed!';
            $this->code = 400;
            }
            $subtask->employees;
            return response()->json(['message' => $this->message,'subtask' => $subtask], $this->code);
        }
        

    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'subtask_priority' => 'required|in:1,2,3,4,5',
        ];
    }
    private function messages(){
        return [
            'subtask_priority.required' => 'Subtask Priority Required',
            'subtask_priority.in' => 'Subtask Value Is Not In Rage 1-5',
        ];
    }
    private function allowed($subtask)
    {
        
        if($subtask->task->campaign->project->byTenant()->id != $this->getTenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($task)
    {
        if($this->getTenant()->projects()->find($subtask->task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

}