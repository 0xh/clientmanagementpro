<?php

namespace App\Http\Controllers\File;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditFile extends Controller
{
    protected $request;
    protected $code = 422;
    protected $message = 'Failed To Edit File Name';

    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->request = $request;
    }
    
    public function __invoke($file)
    {
        $validator = $this->sanitize();
        if($validator->fails())
        {
            $this->message = 'Failed To Edit '. $file->name;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->getAuth()->id === $this->getTenant()->id){
            $file->name = $this->request->name;
            $file->save();
            return response()->json(['file' => $file, 'message' => 'Name Change To: '.$file->name],200);
        }
        return response()->json([],401);
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'name' => 'required|max:30',
        ];
    }
    private function messages(){
        return [
            'name.required' => 'Name Your File',
            'name.max' => 'File Name Too Long',
        ];
    }
}
