<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Carbon\Carbon;
use App\Subtask;
use App\Campaign;
use App\Client;

class CloneProject extends BaseController
{
    protected $message= 'Cannot Clone This Project';
    protected $code = 400;

    public function __construct(Request $request, Client $client)
    {
        $this->middleware(['auth','free-plan']);
        $this->request = $request;
        $this->client = $client;
    }

    public function __invoke($project)
    {
        $validator = $this->sanitize();
        if($validator->fails()){
            $this->message = 'Something is Wrong With Your Input.';
            $this->code = 422;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        
        if($this->getAuth()->can('clone-project',$project) || $this->getAuth()->isSuperAdmin()){
            $newProject = $this->clone($project);
            $newProject->load('campaigns.tasks.subtasks');
            return response()->json(['message' => $this->message, 'project' => $newProject],$this->code);
        }else{
            return response()->json(['message' => $this->message],$this->code);
        }
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
            'client_name' => 'sometimes|required|max:60',
            'newclient' => 'boolean',
            'client.name' => 'sometimes|required|max:60',
            'client.email' => 'sometimes|required|email',
            'client.password' => 'sometimes|required|max:60',
            'client.website' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'due_date' => 'date|after_or_equal:tomorrow',
            'users.*.name' => 'sometimes|required|max:60',
            'users.*.email' => 'sometimes|required|email',
            'users.*.password' => 'sometimes|required|max:60',

        ];
        
    }

    private function messages(){
        return [
            'client_name.required' => 'Describe Your Client',
            'client_name.max' => 'Client Description Too Long (60) Max',
            'newclient.boolean' => 'Value of Existing Should be Boolean',
            'client.name.required' => 'Client Name Is Required',
            'client.name.max' => 'Client Name Too Long (60) Max',
            'client.email.required' => 'Email is Required',
            'client.email.email' => 'Email is Invalid Format',
            'client.password.required' => 'Password Required',
            'client.password.max' => 'Password Too Long (60) Max',
            'client.website.regex' => 'Enter Valid Url',
            'due_date.date' => 'Should Be A Date',
            'due_date.after_or_equal' => 'Set Date Tomorrow Or Later',
            'users.*.name.required' => 'Member Requires A Name',
            'users.*.name.max' => 'Name is Too Long Max(60)',
            'users.*.email.required' => 'Member Email is Required',
            'users.*.email.email' => 'Email Provided Is Invalid Format',
            'users.*.password.required' => 'Password is Required',
            'users.*.password.max' => 'Password Exceeded 60 Characters'
        ];
    }

    private function allowed()
    {
        if($this->getAuth()->id === $this->getTenant()->id)
        {
            return true;
        }
        return false;
    }

    private function isClonable($project)
    {
        return $project->public;
    }

    private function clone($project)
    {

        $campaigns = $this->setCampaigns($project);
        $newProject = $this->createNewProject($project);

            foreach($campaigns as $campaign){
                $newCampaign =  $this->copyCampaign($campaign);
                $newProject->campaigns()->save($newCampaign);

                foreach($campaign->getRelations()['tasks'] as $task){
                        $newTask = $this->copyTask($task);
                        $newCampaign->tasks()->save($newTask);

                        foreach($task->getRelations()['subtasks'] as $subtask){
                            $newSubtask = $this->copySubtask($subtask);
                            $newTask->subtasks()->save($newSubtask);
                            // assign an employee based on campaign
                            $newSubtask->save();
                        }
                }
        }
        $this->message = 'Campaigns Cloned!';
        $this->code = 201;
        return $newProject;
    }

    private function setCampaigns($project)
    {
        // Selected Campaigns
        if(!empty($this->request->campaigns)){
            $campaignlist = $project->campaigns()->get()->pluck('id')->toArray();
            $selected = array_intersect($campaignlist,$this->request->campaigns);
            $campaigns = Campaign::with('tasks.subtasks')->findMany($selected);
            return $campaigns;
        }else {
        // All Campaigns of Project
            $this->loadRelationship($project);
            return $project->getRelations()['campaigns'];
        }
    }

    private function loadRelationship($project)
    {
        $project->load('campaigns.tasks.subtasks');
    }

    private function createNewProject($project)
    {
        $except = ['tenant_id','client_id','projectable_id','projectable_type','slug','public'];
        $newProject = $project->replicate($except);
        $this->createOrAttachClient($newProject);
        unset ($newProject->campaigns);
        $this->addNameIfAny($newProject);
        $this->addClientIfAny($newProject);
        $newProject->push();
        $this->getAuth()->projects()->save($newProject);
        $this->getAuth()->manageProjects()->save($newProject);
        return $newProject;
    }

    private function createOrAttachClient($newProject)
    {
        if($this->request->newclient === true){
            $this->createNewClient();
            $newProject->client()->associate($this->client);
            $this->getAuth()->clients()->save($this->client);
            $this->getAuth()->managedClients()->save($this->client);
            $this->client->save();
        }else{
            $this->addClientIfAny($newProject);
        }
    }

    private function createNewClient()
    {
        $this->client->name = $this->request->client['name'];
        $this->client->email = $this->request->client['email'];
        $this->client->website = $this->request->client['website'];
        $this->client->password = $this->request->client['password'];
    }

    private function addNameIfAny($project)
    {
        if(isset($this->request->client_name)){
            $project->name = $this->request->client_name;
        }
    }

    private function addClientIfAny($newProject)
    {
        if(isset($this->request->client_id['id']))
        {
            $tenant_clients = $this->getTenant()->clients->pluck('id')->toArray();
            $client_id = $this->request->client_id['id'];
            if(in_array($client_id,$tenant_clients))
            {
                $newProject->client()->associate($client_id);
            }
        }else{
                $newProject->client_id = null;
        }
    }

    private function copyCampaign($campaign)
    {
        $campaignCopy = $campaign->replicate();
        unset($campaignCopy->id);
        unset($campaignCopy->project_id);
        unset($campaignCopy->total_points);
        unset($campaignCopy->done_points);
        unset($campaignCopy->tasks);
        $newCampaign = $campaignCopy->create($campaignCopy->toArray());
        return $newCampaign;
    }

    private function copyTask($task)
    {
        $taskCopy = $task->replicate();
        unset ($taskCopy->id);
        unset($taskCopy->campaign_id);
        unset($taskCopy->total_points);
        unset($taskCopy->done_points);
        $newTask =  $taskCopy->create($taskCopy->toArray());
        return $newTask;
    }

    private function copySubtask($subtask)
    {
        $subtaskCopy = $subtask->replicate();
        unset($subtaskCopy->id);
        unset($subtaskCopy->task_id);
        $subtaskCopy->due_date = $this->setDueDate();
        $subtaskCopy->done = false;
        // New Subtask Intance
        $newSubtask = new Subtask();
        // Fill The Instance With Necessary Input
        $newSubtask->fill($subtaskCopy->toArray());
        return $newSubtask;
    }

    private function setDueDate()
    {
        return $this->request->due_date ? $this->request->due_date : Carbon::tomorrow();
    }
}