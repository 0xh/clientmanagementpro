<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use App\Client;

class EditProject extends BaseController
{
    protected $input;

    protected $message = 'Client Updated!';

    protected $code = '200';

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->request = $request;
    }

    public function __invoke($project)
    {
        $validator = $this->sanitize();
        if($validator->fails()){
            $this->message = 'Failed To Edit Client';
            $this->code = 400;
            return response()->json(['message' => $this->message, 'errors' => $validator->errors()], $this->code);
        }
        if($this->allows($project)){
            $this->addName($project);
            $this->createOrEditClient($project);
            $this->save($project);
        }
        $clients = $this->getAuth()->clients;
        $client = Client::find($project->client_id);
        $project = $project;
        return response()->json(['message' => $this->message, 'project' => $project,'clients' => $clients, 'client' => $client], $this->code);
    }

    private function sanitize()
    {
       return $validator = \Validator::make($this->request->all(), $this->rules(), $this->messages());
    }

    private function rules(){
        return 
        [
            'client_name' => 'required|max:60',
            'newclient' => 'boolean',
            'client.name' => 'sometimes|required|max:60',
            'client.email' => 'sometimes|required|email',
            'client.password' => 'sometimes|required|max:60',
            'website' => 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
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
            'website.regex' => 'Enter Valid Url',
        ];
    }

    private function allows($project)
    {
        if($project->byTenant()->id != $this->getTenant()->id)
        {
            $this->code = 401;
            $this->message = 'UnAuthorized';
            return false;
        }
        return true;
    }

   private function AddName($project)
    {
        
        $project->name = $this->request->client_name;
    }
    private function createOrEditClient($project){
        if($this->request->newclient === true){
            $client = Client::forceCreate([
                'name' => $this->request->client['name'],
                'website' => $this->request->website,
                'email' => $this->request->client['email'],
                'password' => $this->request->client['password'],
            ]);
            $this->getAuth()->managedClients()->save($client);
            $project->client_id = $client->id;
        }else{
            $this->AddClientIfAny($project);
        }
    }

    private function AddClientIfAny($project)
    {
        if(isset($this->request->client_id['id']))
        {
            $tenant_clients = $this->getTenant()->clients->pluck('id')->toArray();
            $client_id = $this->request->client_id['id'];
            if(in_array($client_id,$tenant_clients))
            {
            $project->client_id = $client_id;
            }
        }else{
            $project->client_id = null;
        }
    }

    private function save($project)
    {
        $save = $project->save();
        if(!$save){
        $this->message = 'Updating Client Failed';
        $this->code = 404;
        }
    }
}