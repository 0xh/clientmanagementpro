<?php

namespace App\Http\Controllers\Subtask;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Employee;
use App\Notifications\SubtaskAssignedEmail;

class UpdateSubtask extends BaseController
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
    public function __invoke($subtask)
    {
        $validator = $this->sanitize();
        if($validator->fails()){
        $this->message = 'Failed To Edit Task';
        $this->code = 422;
        return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->getAuth()->id === $this->getTenant()->id){
            $this->editSubtask($subtask);
            $this->assignEmployeesIfAny($subtask);
            $this->addUsers($subtask);
            $subtask = $subtask->fresh();
            $subtask->employees;
            $workers = Employee::where('tenant_id',$this->getTenant()->id)->get();
            return response()->json(['message' => $this->message, 'subtask' => $subtask, 'workers' => $workers], $this->code);
        }
        $this->message = 'UnAthorized Request!';
        $this->code = 401;
        return response()->json(['message' => $this->message], $this->code);
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'name' => 'max:255', // |max:30
        'description' => 'max:65535',
        'points' => 'min:1',
        'link' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'priority' => 'in:1,2,3,4,5',
        'done' => 'boolean',
        // 'due_date' => 'date|after_or_equal:tomorrow',
        'users.*.name' => 'sometimes|required|max:60',
        'users.*.email' => 'sometimes|required|email',
        'users.*.password' => 'sometimes|required|max:60',
        ];
    }

    private function messages(){
        return [
            // 'name.required' => 'Define Your Task',
            'name.max' => 'Task Name Too Long Max(255)',
            'description.max' => 'Job Description Reach Character Limit',
            'points.required' => 'Points is Required',
            'points.min' => 'Minimum Point is 1',
            'done.boolean' => 'Done Should Be A Boolean Value',
            'link.regex' => 'Enter Valid Url',
            'priority.in' => 'Task Value Is Not In Rage 1-5',
            // 'due_date.date' => 'Should Be A Date',
            // 'due_date.after_or_equal' => 'Set Date Tomorrow Or Later',
            'users.*.name.required' => 'Member Requires A Name',
            'users.*.name.max' => 'Name is Too Long Max(60)',
            'users.*.email.required' => 'Member Email is Required',
            'users.*.email.email' => 'Email Provided Is Invalid Format',
            'users.*.password.required' => 'Password is Required',
            'users.*.password.max' => 'Password Exceeded 60 Characters'
        ];
    }

    private function editSubtask($subtask)
    {
        
        $this->addLink($subtask);
        $this->addDescription($subtask);
        $this->addPriority($subtask);
        $this->addDone($subtask);
        $this->addPoints($subtask);
        $this->addDueDate($subtask);
        $this->addName($subtask);
        $subtask->save();
    }

    private function addName($subtask)
    {
        if($this->request->has('name')){
            $subtask->name = $this->request->name;
        }
    }

    private function addDescription($subtask)
    {
        if($this->request->has('description')){
            $subtask->description = clean($this->request->description);
        }
    }

    private function addLink($subtask)
    {
        if($this->request->has('link')){
            $subtask->link = $this->request->input('link');
        }
    }

    private function addPriority($subtask){
        if($this->request->has('priority')){
            $subtask->priority = $this->request->priority;
            }
    }

    private function addPoints($subtask){
        if($this->request->has('points')){
            $subtask->points = $this->request->points;
            }
    }

    private function addDueDate($subtask)
    {
        if($this->request->has('due_date')){
            $subtask->due_date = $this->request->due_date;
        }
    }

    private function addDone($subtask)
    {
        if($this->request->has('done')){
            $subtask->done = $this->request->done;
        }
    }

    private function addUsers($subtask)
    {
        $users_input = $this->request->users;
        if($this->request->newCollaborator){
            for ($i=0; $i < count($users_input); $i++) { 
                if(!$users_input[$i]['name'] || !$users_input[$i]['email'] || !$users_input[$i]['password']){
                    unset($users_input[$i]);
                }
            }
            $project = $subtask->task->campaign->project;
            $data = array();
            foreach ($users_input as $user) {
                $employee = Employee::forceCreate($user);
                $this->getAuth()->employees()->save($employee);
                $this->getTenant()->managedEmployees()->save($employee);
                $data[$employee->id] = ['project_id' => $project->id];
            }
            $subtask->employees()->attach($data);
        }
        $employees = $users_input;
        if($employees && $this->request->sendEmail === true){
            foreach($employees as $employee){
                $employee = Employee::where('email', $employee['email'])->first();
                if($employee){
                $employee->notify(new SubtaskAssignedEmail($subtask,$this->getTenant(),$employee));
                }
            }
        }
        
    }

    private function assignEmployeesIfAny($subtask)
    {
        $project = $subtask->task->campaign->project;
        $employee_lists = $this->hasAssignedEmployees();
        if(count($employee_lists))
        {   
            $data = array();
            foreach($employee_lists as $id){
            $data[$id] =['project_id' => $project->id];
            }
            $subtask->employees()->sync($data);
        }else{
            $subtask->employees()->sync([]);
        }
        $employees = $subtask->employees;
        if(count($employees) && $this->request->sendEmail === true){
            foreach($employees as $employee){
                $employee->notify(new SubtaskAssignedEmail($subtask,$this->getTenant(),$employee));
            }
        }
       
    }

    private function hasAssignedEmployees()
    {
        $employees = $this->request->assignedEmployees;
        $employee_ids = array();
        $selected = array();
        if($employees){
            
            for ($i=0; $i < count($employees); $i++) { 
                array_push($employee_ids,$employees[$i]['id']);
            }
            $employee_list = $this->getTenant()->employees->pluck('id')->toArray();
            $selected = array_intersect($employee_list,$employee_ids);
        }
        return $selected;
    }
    
}