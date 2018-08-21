<?php

namespace App\Http\Controllers\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class AddComment extends BaseController
{
    protected $code = 400;
    protected $message = 'Fail to Create Comment';
    protected $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->request = $request;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($task,$comment = null)
    {
        $validator = $this->sanitize();
        if($validator->fails()){
            $this->code = 422;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->allowed($task) || $this->createdBy($task)){
            $parent = $task->comments->find($comment);
            $user = $this->getAuth();
            
            $comment = $task->comment([
                'title' => $user->name,
                'body' => $this->request->body,
            ], $user,$parent);
            $comment->creator;
            $comment->children;

            $this->code = 200;
            $this->message = 'Comment Created!';

            return response()->json(['message' => $this->message, 'comment' => $comment],$this->code);
        }
        $this->code = 401;
        $this->message = 'UnAuthorized Request';
        return response()->json(['message' => $this->message], $this->code);
        
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'body' => 'required|min:1|max:255',
        ];
    }

    private function messages(){
        return [
            'body.required' => 'Comment Body Is Required',
            'body.min' => 'Comment Body Should Be At Least 3 Characters',
            'body.max' => 'Comment Body is Too Long (255) Max Only',
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

    
}