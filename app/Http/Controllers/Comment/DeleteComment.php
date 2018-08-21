<?php

namespace App\Http\Controllers\Comment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;

class DeleteComment extends BaseController
{
    protected $code = 204;
    protected $message = 'Comment Deleted';
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
    public function __invoke($task,$comment)
    {
        if($this->isAdmin() || $this->createdBy($comment)){
            if($comment->hasChildren()){
                $children = $comment->children;
                foreach($children as $child){
                    $child->delete();
                }
            }
            $comment->delete();
        return response()->json(['message' => $this->message],$this->code);
        }
        $this->code = 401;
        $this->message = 'UnAuthorized Request';
        return response()->json(['message' => $this->message], $this->code);
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