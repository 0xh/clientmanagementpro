<?php

namespace App\Http\Controllers\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class ShowComment extends BaseController
{
    protected $code = 200;
    protected $message = 'Fail to Load Comments';
    protected $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        if($this->allowed($task) || $this->createdBy($task)){
            $comments = $task->comments()->with('children.creator', 'creator')->where('parent_id', null)->get();
            return response()->json(['comments' => $comments],$this->code);
        }
        $this->code = 401;
        return response()->json(['message' => $this->message],$this->code);
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
}