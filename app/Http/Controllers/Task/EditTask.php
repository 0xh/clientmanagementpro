<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Spatie\Activitylog\Models\Activity;

class EditTask extends BaseController
{

    protected $request;

    protected $message = 'Task Edited!';

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
            $this->message = 'Failed To Edit '. $task->name;
            $this->code = 400;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->allowed($task) || $this->createdBy($task))
        {
            $this->editTask($task);
            $this->save($task);
            $log = Activity::where('subject_type', 'App\Task')->where('subject_id', $task->id)->latest()->first();
            return response()->json(['message' => 'Task: '.$task->name. ' Edited!', 'log' => $log], 200);
        }
        

    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'task_name' => 'required', //|max:30
        'task_link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'task_description' => 'max:200',
        'task_recurring' => 'boolean',
        // 'task_interval' => 'integer|min:0|max:999'
        ];
    }
    private function messages(){
        return [
            'task_name.required' => 'Name Your Task',
            // 'task_name.max' => 'Task Name Too Long',
            'task_description.max' => 'Description Too Long',
            'task_link.regex' => 'Enter Valid Url',
            'task_recurring.boolean' => 'Recurring Value Must Be Either True or False',
            // 'task_interval.integer' => 'Task Interval Provided is Not Integer',
            // 'task_interval.min' => 'Task Interval Lowest Value: 0',
            // 'task_interval.max' => 'Task Interval Highest Value: 999'
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
        $this->addName($task);
        $this->addLink($task);
        $this->addRecurring($task);
        $this->addInterval($task);
        $this->addDescription($task);
    }

    private function validateTask(){
        $this->validate($this->input, [
            'task_name' => 'required|max:30',
            'task_link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'task_description' => 'max:200',
            ]);
    }

    private function addName($task)
    {
        $task->name = $this->request->task_name;
    }

    private function addLink($task)
    {
        if(isset($this->request->task_link)){
        $task->link = $this->request->task_link;
        }
    }

    private function addRecurring($task){
        if(isset($this->request->task_recurring)){
            $task->recurring = $this->request->task_recurring;
            }
    }

    private function addInterval($task){
        if(isset($this->request->task_interval)){
            $task->interval = $this->request->task_interval;
            }
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
        $this->message = 'Editing Task Failed!';
        $this->code = 404;
        }
    }
}