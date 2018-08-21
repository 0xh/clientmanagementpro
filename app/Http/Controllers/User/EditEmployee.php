<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;
use App\Task;


class EditEmployee extends BaseController
{   
    protected $request;
    
    protected $message = 'Failed to Update Teammates';

    protected $code = '200';

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
    public function __invoke($employee)
    {
        $validator = $this->sanitize($employee);
        if($validator->fails()){
            $this->code = 422;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->getAuth()->id === $this->getTenant()->id){
            $this->updateEmployee($employee);
            $this->updatePasswordIfPresent($employee);
            $this->message = 'Teammate Updated!';
            $worker = $this->getWorker($employee);
            return response()->json(['message' => $this->message, 'employee' => $worker], $this->code);
        }
        $this->code = 401;
        $this->message = 'UnAuthorized Action!';
        return response()->json(['message' => $this->message], $this->code);
    }

    private function getWorker($employee){
            $worker = $employee;
            $tasks = [];
            $count = 0;
            $subtasks = $employee->subtasks;
            if($subtasks ){
                foreach($subtasks as $subtask){
                    $tasks[$subtask->task_id] = $subtask->task_id;
                }
                $tasks = array_flatten($tasks);
                $tasks = Task::findMany($tasks)->toArray();
                $worker['tasks'] =  $tasks;
                $count++;
            }else{
                $worker['tasks'] = [];
            }
            
            return $worker;
    }

    private function sanitize($employee)
    {
       return $validator = \Validator::make($this->request->all(), $this->rules($employee), $this->messages());
    }

    private function rules($employee)
    {
        return 
        [
        'name' => 'required|max:30',
        'email' => [
            'required',
            'email',
             Rule::unique('employees')->ignore($employee->id),
        ],
        'password' => 'sometimes|required|min:6|max:60|confirmed',
        ];
    }

    private function messages()
    {
        return [
            'name.required' => 'Name Field is Required',
            'name.max' => 'Name is Too Long (60) Max',
            'email.required' => 'Email is Required',
            'email.email' => 'Email Format Is Invalid',
            'email.unique' => 'Email is Already Taken',
            'password.min' => 'Password Needs to Be At Least (6) Characters',
            'password.max' => 'Password Exceeds 60 Characters',
            'password.required' => 'Password is Required',
            'password.confirmed' => 'Password Confirmation Does Not Match'
        ];
    }
    private function updateEmployee($employee)
    {
        $employee->fill([
            'name' => $this->request->name,
            'email' => $this->request->email
        ])->save();
    }
    private function updatePasswordIfPresent($employee)
    {
        if($this->request->has('password')){
            $employee->forceFill([
                'password' => $this->request->password
            ])->save();
        }
    }
}