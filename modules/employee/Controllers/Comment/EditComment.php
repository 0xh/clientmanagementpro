<?php

namespace Modules\Employee\Controllers\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class EditComment extends BaseController
{
    protected $code = 200;
    protected $message = 'Fail to Create Comment';
    protected $request;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth:employee');
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
        if($this->isAdmin() || $this->createdBy($comment)){
        $parent = $task->comments->find($comment);
        $user = $this->getAuth();
        $comment = $task->updateComment($comment,[
            'body' => $this->request->body,
        ], $user,$parent);
        
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

    private function isAdmin()
    {
        
        if($this->getTenant()->id === $this->getAuth()->id)
        {
            return true;
        }
        return false;
    }

    private function createdBy($comment)
    {
        if($this->getAuth()->comments()->find($comment))
        {
            return true;
        }
        return false;
    }

    
}