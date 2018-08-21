<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Spatie\Activitylog\Models\Activity;

class EditDescription extends BaseController
{

    protected $request;

    protected $message = 'Job Description Edited!';

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
    public function __invoke($task)
    {
        $validator = $this->sanitize();
        if($validator->fails())
        {
            $this->message = 'Failed To Edit Job '. $task->name;
            $this->code = 400;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->allowed($task) || $this->createdBy($task))
        {
            $this->editTask($task);
            $this->save($task);
            $task = $task->fresh();
            return response()->json(['message' => 'Job : '.$task->name. ' Description Edited!', 'description' => $task->description], 200);
        }
        

    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'task_description' => 'required',
        ];
    }
    private function messages(){
        return [
            'task_description.required' => 'Job Description Required',
        ];
    }
    private function allowed($task)
    {
        
        if($task->campaign->project->byTenant()->id != $this->getTenant()->id)
        {
            return false;
        }
        return true;
    }

    private function createdBy($task)
    {
        if($this->getTenant()->projects()->find($task->campaign->project->id))
        {
            return true;
        }
        return false;
    }

    private function editTask($task)
    {
        $this->addDescription($task);
    }

    private function addDescription($task)
    {
        if(isset($this->request->task_description)){
        $task->description = $this->request->task_description;
        }
    }

    private function save($task)
    {
        $save = $task->save();
        if(!$save){
        $this->message = 'Editing Job Description Failed!';
        $this->code = 404;
        }
    }
}