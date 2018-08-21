<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Client;
use App\Project;
use App\Notifications\ClientAssignedEmail;
use App\Notifications\ClientRegistrationEmail;

class AddClient extends BaseController
{
    protected $client;
    
    protected $request;

    protected $message = 'Client Account Created';

    protected $code = '200';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Client $client,Request $request)
    {
        $this->middleware(['auth','free-plan']);
        // add here middleware for free user... creating only 3 projects
        $this->request = $request;
        $this->client = $client;
    }

    /**
     * Receive Project Id
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        $validator = $this->sanitize();
        if($validator->fails()){
            $this->message = 'Failed To Create Client Account';
            $this->code = 422;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        
        $client = Client::forceCreate($this->request->only([
            'name',
            'email', 
            'password',
            'website',
            'first_name',
            'last_name',
            'phone',
            'address',
            'address_line_2',
            'city',
            'zip',
            'country',
            'notes',
            ]));
        
        $this->addlinks($client);
        $client->notify(new ClientRegistrationEmail($this->getTenant(),$client));
        // Assign All Projects to Client If Any
        $this->assignedProjectsIfAny($client);
        // Create Project 
        $this->createNewProjectIfAny($client);
        
        // Created By clientable
        $this->getAuth()->clients()->save($client); // Morph
        // Owned ByTeant
        $this->getTenant()->managedClients()->save($client); //tenant_id
        $client->projects;
        // return updated project list without any project assignement to clients
        $projectlist = Project::where('tenant_id',$this->getTenant()->id)->where('client_id', null)->get();
        return response()->json(['message' => $this->message, 'client' => $client, 'projectlist' => $projectlist], $this->code);
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
        'name' => 'required|max:60',
        'first_name' => 'required|max:60',
        'last_name' => 'required|max:60',
        'phone' => 'max:60',
        'address' => 'max:225',
        'address_line_2' => 'max:225',
        'city' => 'max:60',
        'zip' => 'max:60',
        'country' => 'max:60',
        'notes' => 'max:255',
        'email' => 'required|email|unique:clients,email',
        'password' => 'required|min:6|max:60',
        'new_project' => 'boolean',
        'projects.*.name' => 'sometimes|required|max:60',
        'website' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        'links.*' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
        ];
    }

    private function messages(){
        return [
            'name.required' => 'Company Name Field is Required',
            'name.max' => 'Company Name is Too Long (60) Max',
            'first_name.required' => 'First Name Field is Required',
            'first_name.max' => 'First Name is Too Long (60) Max',
            'last_name.required' => 'Last Name Field is Required',
            'last_name.max' => 'Last Name is Too Long (60) Max',
            'phone.size' => 'Phone Number Size Exceed (60) Max',
            'address.max' => 'Address Line 1 Exceeds (255) Max',
            'address_line_2.max' => 'Address Line 2 Exceeds (255) Max',
            'city.max' => 'City Exceeds (60) Max',
            'zip.max' => 'Province/State Exceeds (60) Max',
            'country.max' => 'Country Exceeds (60) Max',
            'notes.max' => 'Notes Exceeds (255) Max',
            'email.required' => 'Email is Required',
            'email.email' => 'Email Format Is Invalid',
            'email.unique' => 'Email Is Already taken',
            'password.min' => 'Password Needs to Be At Least (6) Characters',
            'password.max' => 'Password Exceeds 60 Characters',
            'password.required' => 'Password is Required',
            'projects.*.name.required' => 'Project Description is Required',
            'projects.*.name.max' => 'Project Description is Too Long Max(60)',
            'website.regex' => 'Enter Valid Url',
            'links.*.regex' => 'Enter Valid Url',
        ];
    }

    private function createNewProjectIfAny($client){
        if($this->request->new_project){
        // get Projects Input
        $projects_input = $this->request->projects;
        // we unset unfilled input  
        for ($i=0; $i < count($projects_input); $i++) { 
            if(!$projects_input[$i]['name']){
                unset($projects_input[$i]);
            }
        }
        // Get Allowed Project Counts
        $count = $this->limitProjectCount();
        // limit project creation
        if($count > 0){
            for ($i=0; $i < $count; $i++) { 
                $project = Project::create($projects_input[$i]);
                // attach project to client
                $client->projects()->save($project);
                // morph projectable
                $this->getAuth()->projects()->save($project);
                // manageProjects ByTenant
                $this->getTenant()->manageProjects()->save($project);
                $client->notify(new ClientAssignedEmail($project,$client,$this->getTenant()));
            }
        }
            
        }
    }

    private function addlinks($client)
    {
        $links = $client->links;
        if($count = count($this->request->links)){
            foreach ($this->request->links as $key => $value) {
                $links[$key] = $value;
            }
        }
        $client->links = $links;
        $client->save();
    }

    private function limitProjectCount(){
        // get current project count
        $current_count = $this->getAuth()->projects()->count();
        // get the plan
        $plan = $this->getAuth()->sparkPlan();
        // if plan is free
        if($plan->name === 'Free'){
            // return the remaining count
            $max = 3;
            $remaining = (int)($max - $current_count);
            if($remaining < 0) {
                return 0;
            }
            return $remaining;
        }
        // No Limit For VIP
        return count($this->request->projects);
        
    }
    private function hasAssignedProjects(){
        $projects = $this->request->assignedProjects;
        $projects_ids = array();
        $selected = array();
        if($projects){
            for ($i=0; $i < count($projects); $i++) { 
                array_push($projects_ids,$projects[$i]['id']);
            }
            $project_list = $this->getTenant()->projects->pluck('id')->toArray();
            $selected = array_intersect($project_list,$projects_ids);
        }
        return $selected;
    }

    private function assignedProjectsIfAny($client){
        $project_list = $this->hasAssignedProjects();
        if(count($project_list))
        {   
            foreach($project_list as $id){
            $project = Project::find($id);
            $client->projects()->save($project);
            $client->notify(new ClientAssignedEmail($project,$client,$this->getTenant()));
            }
        }

    }
}